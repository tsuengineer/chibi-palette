const extractMetaDataFromPng = async (file) => {
    const arrayBuffer = await file.arrayBuffer();

    const dataView = new DataView(arrayBuffer);
    const pngSignature = new Uint8Array([137, 80, 78, 71, 13, 10, 26, 10]);
    const fileSignature = new Uint8Array(arrayBuffer.slice(0, 8));
    if (!pngSignature.every((value, index) => value === fileSignature[index])) {
        throw new Error('Error: Invalid PNG file format.');
    }

    const chunks = [];
    let offset = 8;
    while (offset < arrayBuffer.byteLength) {
        const length = dataView.getUint32(offset);
        offset += 4;
        const type = String.fromCharCode(...[...Array(4)].map((_, i) => dataView.getUint8(offset + i)));
        offset += 4;
        if (type === 'tEXt' || type === 'iTXt') {
            for (let i = offset; i < offset + length; i++) {
                if (dataView.getUint8(i) === 0) {
                    const keyword = new TextDecoder().decode(arrayBuffer.slice(offset, i));
                    const text = new TextDecoder().decode(arrayBuffer.slice(i + 1, offset + length));
                    chunks.push({ keyword, text });
                    break;
                }
            }
        }
        offset += length + 4;
    }

    const softwareChunk = chunks.find(
        (e) => e.keyword === "Software" && e.text === "NovelAI"
    );
    let metaData = {};
    if (softwareChunk) {
        parseDescriptionAndComment(chunks, metaData);
    } else {
        parseParameters(chunks, metaData);
    }
    return metaData;
};

const parseDescriptionAndComment = (chunks, info) => {
    const description = chunks.find(e => e.keyword === "Description");
    const comment = chunks.find(e => e.keyword === "Comment");
    if (description) {
        info.prompt = description.text;
    }
    if (comment) {
        const {
            uc, steps, sampler, seed, strength, noise, scale
        } = JSON.parse(comment.text);
        Object.assign(info, {
            negative_prompt: uc, steps, sampler, seed, strength, noise, scale
        });
    }
};

const parseParameters = (chunks, info) => {
    const parameters = chunks.find(e => e.keyword === "parameters");
    const paramMapping = {
        "Steps": "steps",
        "Sampler": "sampler",
        "CFG scale": "scale",
        "Seed": "seed",
        "Model": "model",
    };
    if (parameters) {
        const lines = parameters.text.split(/\n/);
        let mode = "prompts";
        for (const line of lines) {
            if (mode === "prompts") {
                if (line.match(/^Negative prompt: /)) {
                    mode = "negative_prompts";
                } else if (line.match(/^Steps: /)) {
                    mode = "options";
                } else {
                    info.prompt ??= "";
                    info.prompt += line + "\n";
                    continue;
                }
            }
            if (mode === "negative_prompts") {
                if (line.match(/^Steps: /)) {
                    mode = "options";
                } else {
                    info.negative_prompt ??= "";
                    info.negative_prompt += line.replace(/^Negative prompt: /, "") + "\n";
                    continue;
                }
            }
            if (mode === "options") {
                const paramPairs = line.split(/,\s?/);
                for (const pair of paramPairs) {
                    const [key, value] = pair.split(/:\s?/);
                    if (key in paramMapping && value !== "") {
                        info[paramMapping[key]] = value;
                    }
                }
            }
        }
    }
};
