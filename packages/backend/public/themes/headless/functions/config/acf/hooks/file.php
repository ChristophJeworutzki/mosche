<?php

use MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxAsset;

function transform_file($value, $post_id, $field) {

  if (empty($value)) {
    return $value;
  }

  if (!class_exists('MediaCloud\Plugin\Tools\Video\Driver\Mux\Models\MuxAsset')) {
    return $value;
  }

  if ($field['return_format'] === 'array') {
    $attachmentId = $value['ID'];
  } else {
    return $value;
  }

  if (!wp_attachment_is('video', $attachmentId)) {
    return $value;
  }

  $muxAsset = MuxAsset::assetForAttachment($attachmentId);
  $playbackId = $muxAsset->__get('publicPlaybackID');

  return [
    'id'            => intval($muxAsset->attachmentId),
    'playbackID'    => $playbackId,
    'title'         => $muxAsset->title,
    'width'         => intval($muxAsset->width),
    'height'        => intval($muxAsset->height),
    'status'        => $muxAsset->status,
    'duration'      => floatval($muxAsset->duration),
    'aspectRatio'   => $muxAsset->aspectRatio,
    'thumbnailTime' => floatval(get_post_meta($attachmentId, '_thumbnail_time', true)),
    'url'           => wp_get_attachment_url($attachmentId),
    'caption'       => $value['caption'],
    'description'   => $value['description'],
  ];
}

add_filter('acf/format_value/type=file', 'transform_file', 20, 3);
