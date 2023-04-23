@props(['twitter', 'instagram'])

@if ($twitter)
    <span style="color: #1DA1F2;">
                <a href="https://twitter.com/{{ $twitter }}" target="_blank">
                    <i class="fa-brands fa-twitter"></i>
                </a>
            </span>
@endif
@if ($instagram)
    <span class="ml-1 px-1 text-white insta_button" style="background: linear-gradient(#5478f2 0%, #f23f79 60%, orange 100%);">
                <a href="https://www.instagram.com/{{ $instagram }}" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </span>
@endif
