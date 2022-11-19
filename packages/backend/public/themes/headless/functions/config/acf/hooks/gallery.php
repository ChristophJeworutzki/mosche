<?php

use MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxAsset;

function transform_gallery($value, $post_id, $field) {

  if (empty($value)) {
    return $value;
  }

  if (is_array($value)) {
    foreach ($value as $key => $attachment) {
      if (wp_attachment_is('image', $attachment['id'])) {
        $value[$key] = [
          'type'          => 'image',
          'id'            => $attachment['id'],
          'title'         => $attachment['title'],
          'width'         => $attachment['width'],
          'height'        => $attachment['height'],
          'mimeType'      => $attachment['mime_type'],
          'alt'           => $attachment['alt'],
          'caption'       => $attachment['caption'],
          'description'   => $attachment['description'],
          'aspectRatio'   => get_aspect_ratio($attachment['width'], $attachment['height']),
          'orientation'   => get_orientation($attachment['width'], $attachment['height']),
          'src'           => $attachment['url'],
          'srcset'        => wp_get_attachment_image_srcset($attachment['id']),
        ];
      } else if (wp_attachment_is('video', $attachment['id'])) {

        if (class_exists('MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxAsset')) {
          $muxAsset = MuxAsset::assetForAttachment($attachment['id']);
          $playbackId = $muxAsset->__get('publicPlaybackID');
          $value[$key] = [
            'type'          => 'video',
            'id'            => $attachment['id'],
            'playbackID'    => $playbackId,
            'title'         => $attachment['title'],
            'width'         => intval($muxAsset->width),
            'height'        => intval($muxAsset->height),
            'status'        => $muxAsset->status,
            'duration'      => floatval($muxAsset->duration),
            'aspectRatio'   => $muxAsset->aspectRatio,
            'orientation'   => get_orientation(intval($muxAsset->width), intval($muxAsset->height)),
            'thumbnailTime' => floatval(get_post_meta($attachment['id'], '_thumbnail_time', true)),
            'src'           => $attachment['url'],
            'caption'       => $attachment['caption'],
            'description'   => $attachment['description'],
          ];
        } else {
          $value[$key] = [
            'type'          => 'video',
            'id'            => $attachment['id'],
            'title'         => $attachment['title'],
            'width'         => $attachment['width'],
            'height'        => $attachment['height'],
            'mimeType'      => $attachment['mime_type'],
            'alt'           => $attachment['alt'],
            'caption'       => $attachment['caption'],
            'description'   => $attachment['description'],
            'aspectRatio'   => get_aspect_ratio($attachment['width'], $attachment['height']),
            'orientation'   => get_orientation($attachment['width'], $attachment['height']),
            'src'           => $attachment['url'],
          ];
        }
      }
    }
    return $value;
  } else {
    return $value;
  }
}

add_filter('acf/format_value/type=gallery', 'transform_gallery', 20, 3);
