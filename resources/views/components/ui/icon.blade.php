@props([
    'name', // bell, bookmark, edit, filter, like, location, comment, search, send, settings, share
])

@php
    $filename = match($name) {
        'bell' => 'bell-svgrepo-com.svg',
        'bookmark' => 'bookmark-svgrepo-com.svg',
        'edit' => 'edit-4-svgrepo-com.svg',
        'filter' => 'filters-2-svgrepo-com.svg',
        'like' => 'like-svgrepo-com.svg',
        'location' => 'location-1-svgrepo-com.svg',
        'comment' => 'message-square-lines-svgrepo-com.svg',
        'search' => 'search-svgrepo-com.svg',
        'send' => 'send-2-svgrepo-com.svg',
        'settings' => 'settings-svgrepo-com.svg',
        'share' => 'share-icon.svg',
        default => null
    };

    $innerContent = '';
    $viewBox = '0 0 24 24';
    $originalFill = 'none';
    $originalStroke = 'currentColor';

    if ($filename) {
        $path = public_path('storage/icon/' . $filename);
        if (file_exists($path)) {
            $svgContent = file_get_contents($path);
            
            // Remove XML declaration and comments
            $svgContent = preg_replace('/<\?xml.*?\?>/i', '', $svgContent);
            $svgContent = preg_replace('/<!--.*?-->/is', '', $svgContent);
            
            // Normalize strokes and fills to currentColor
            $svgContent = str_replace(['stroke="#000000"', 'stroke="black"'], 'stroke="currentColor"', $svgContent);
            $svgContent = str_replace(['fill="#000000"', 'fill="black"'], 'fill="currentColor"', $svgContent);
            
            // Parse SVG tag attributes and content
            if (preg_match('/<svg[^>]* viewBox="([^"]+)"[^>]*>(.*)<\/svg>/is', $svgContent, $matches)) {
                $viewBox = $matches[1];
                $innerContent = $matches[2];
            } elseif (preg_match('/<svg[^>]*>(.*)<\/svg>/is', $svgContent, $matches)) {
                $innerContent = $matches[1];
            }
            
            // Extract default fill and stroke from outer svg tag if present
            if (preg_match('/<svg[^>]* fill="([^"]+)"/i', $svgContent, $fillMatches)) {
                $originalFill = $fillMatches[1];
                if ($originalFill === '#000000' || $originalFill === 'black') {
                    $originalFill = 'currentColor';
                }
            }
            
            if (preg_match('/<svg[^>]* stroke="([^"]+)"/i', $svgContent, $strokeMatches)) {
                $originalStroke = $strokeMatches[1];
                if ($originalStroke === '#000000' || $originalStroke === 'black') {
                    $originalStroke = 'currentColor';
                }
            }
        }
    }
@endphp

@if($innerContent)
    <svg {{ $attributes->merge([
        'viewBox' => $viewBox,
        'fill' => $originalFill,
        'stroke' => $originalStroke,
    ]) }}>
        {!! $innerContent !!}
    </svg>
@endif
