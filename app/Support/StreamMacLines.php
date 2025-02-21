<?php

namespace App\Support;

class StreamMacLines extends \php_user_filter
{
    public $params;

    public function onCreate()
    {
        $this->params = stream_filter_params_get($this);
        return true;
    }

    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            // First convert all line endings to \n
            $bucket->data = str_replace(["\r\n", "\r"], "\n", $bucket->data);
            
            // Then convert to the desired line ending
            $lineEnding = $this->params['params']['line_ending'] ?? "\r\n";
            $bucket->data = str_replace("\n", $lineEnding, $bucket->data);
            
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }
}
