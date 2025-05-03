<?php

if (!function_exists('highlight_search')) {
    /**
     * Highlights the search term in the string.
     *
     * @param string $text
     * @param string $search
     * @return string
     */
    function highlight_search(string $text, string $search): string
    {
        $pattern = '/' . preg_quote($search, '/') . '/i'; // Case-insensitive search
        return preg_replace($pattern, '<span class="bg-warning text-dark">$0</span>', $text); // Highlight with a background color
    }
}
