<?php
 function generateWAV($Word)
  {
  ob_clean();
  $audiopatch = dirname(__FILE__).DIRECTORY_SEPARATOR.'audio'.DIRECTORY_SEPARATOR;
  
  for($i = 0; $i < strlen($Word); ++$i) {
      $letters[] = $Word{$i};
    }
	$letters[] = "end";
    $first = true; // use first file to write the header...
    $data_len    = 0;
    $files       = array();
    $out_data    = '';

    foreach ($letters as $letter) {
      $filename = $audiopatch . strtoupper($letter) . '.wav';

      $fp = fopen($filename, 'rb');

      $file = array();

      $data = fread($fp, filesize($filename)); // read file in

      $header = substr($data, 0, 36);
      $body   = substr($data, 44);


      $data = unpack('NChunkID/VChunkSize/NFormat/NSubChunk1ID/VSubChunk1Size/vAudioFormat/vNumChannels/VSampleRate/VByteRate/vBlockAlign/vBitsPerSample', $header);

      $file['sub_chunk1_id']   = $data['SubChunk1ID'];
      $file['bits_per_sample'] = $data['BitsPerSample'];
      $file['channels']        = $data['NumChannels'];
      $file['format']          = $data['AudioFormat'];
      $file['sample_rate']     = $data['SampleRate'];
      $file['size']            = $data['ChunkSize'] + 8;
      $file['data']            = $body;

      if ( ($p = strpos($file['data'], 'LIST')) !== false) {
        // If the LIST data is not at the end of the file, this will probably break your sound file
        $info         = substr($file['data'], $p + 4, 8);
        $data         = unpack('Vlength/Vjunk', $info);
        $file['data'] = substr($file['data'], 0, $p);
        $file['size'] = $file['size'] - (strlen($file['data']) - $p);
      }

      $files[] = $file;
      $data    = null;
      $header  = null;
      $body    = null;

      $data_len += strlen($file['data']);

      fclose($fp);
    }

    $out_data = '';
    for($i = 0; $i < sizeof($files); ++$i) {
      if ($i == 0) { // output header
        $out_data .= pack('C4VC8', ord('R'), ord('I'), ord('F'), ord('F'), $data_len + 36, ord('W'), ord('A'), ord('V'), ord('E'), ord('f'), ord('m'), ord('t'), ord(' '));

        $out_data .= pack('VvvVVvv',
                          16,
                          $files[$i]['format'],
                          $files[$i]['channels'],
                          $files[$i]['sample_rate'],
                          $files[$i]['sample_rate'] * (($files[$i]['bits_per_sample'] * $files[$i]['channels']) / 8),
                          ($files[$i]['bits_per_sample'] * $files[$i]['channels']) / 8,
                          $files[$i]['bits_per_sample'] );

        $out_data .= pack('C4', ord('d'), ord('a'), ord('t'), ord('a'));

        $out_data .= pack('V', $data_len);
      }

      $out_data .= $files[$i]['data'];
    }

    echo $out_data;
  }

?>