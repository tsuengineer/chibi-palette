<?php

namespace App\Utils;

class ResponseUtil
{
    /**
     * @var bool アップロードが成功したかどうか
     */
    private bool $success;

    /**
     * @var array アップロードに関するエラーメッセージを格納する配列
     */
    private array $errors;

    public function __construct(bool $success, array $errors = [])
    {
        $this->success = $success;
        $this->errors = $errors;
    }

    /**
     * 成功したアップロードを示すUploadResultインスタンスを返す
     *
     * @return self
     */
    public static function createSuccess(): self
    {
        return new self(true);
    }

    public static function updateSuccess(): self
    {
        return new self(true);
    }

    /**
     * エラーメッセージを含むUploadResultインスタンスを返す
     *
     * @param array $errors
     * @return self
     */
    public static function createWithErrors(array $errors): self
    {
        return new self(false, $errors);
    }

    public static function updateWithErrors(array $errors): self
    {
        return new self(false, $errors);
    }

    /**
     * アップロードが成功したかどうか
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * アップロードに関するエラーメッセージを含む配列を返す
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
