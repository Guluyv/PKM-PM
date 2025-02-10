<?php
namespace Helpers;

class VideoHelper {
    /**
     * Mengkonversi URL YouTube normal menjadi URL embed
     * @param string $url URL YouTube
     * @return string URL embed
     */
    public static function getYoutubeEmbedUrl($url) {
        $videoId = '';
        
        // Menggunakan pattern matching yang sudah ada karena sudah terbukti berfungsi
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            $videoId = $id[1];
        } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
            $videoId = $id[1];
        } else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
            $videoId = $id[1];
        } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            $videoId = $id[1];
        }
        
        if (empty($videoId)) {
            return $url; // Return original URL if no valid YouTube ID found
        }
        
        return 'https://www.youtube.com/embed/' . $videoId;
    }

    /**
     * Mendapatkan thumbnail dari video YouTube
     * @param string $url URL YouTube
     * @return string URL thumbnail
     */
    public static function getYoutubeThumbnail($url) {
        $videoId = '';
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
            $videoId = $id[1];
        } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
            $videoId = $id[1];
        }
        
        if ($videoId) {
            return "https://img.youtube.com/vi/" . $videoId . "/mqdefault.jpg";
        }
        return '';
    }

    /**
     * Validasi apakah URL adalah URL YouTube yang valid
     * @param string $url URL yang akan divalidasi
     * @return boolean
     */
    public static function isValidYoutubeUrl($url) {
        $patterns = [
            '/youtube\.com\/watch\?v=([^\&\?\/]+)/',
            '/youtube\.com\/embed\/([^\&\?\/]+)/',
            '/youtube\.com\/v\/([^\&\?\/]+)/',
            '/youtu\.be\/([^\&\?\/]+)/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }
        return false;
    }
}