<?php 
/* 
    Youtube Helper 
    Returns embedded youtube video, related videos and video images based on video id 

    @author Carly Marie 
    @license MIT 
    @version 1.0 
*/ 
    App::import('Helper', 'Html'); 
    class YoutubeHelper extends HtmlHelper { 
        var $api_links = array( 
            'image'   => 'http://i.ytimg.com/vi/%s/%s.jpg',                     // Location of youtube images
            'video'   => 'http://gdata.youtube.com/feeds/api/videos/%s',        // Location of youtube videos
            'player'  => 'http://www.youtube.com/v/%s?%s',                      // Location of youtube player 
            'channel' => 'http://www.youtube.com/user/%s',                      // Location of youtube user channel
            'related' => 'http://gdata.youtube.com/feeds/api/videos/%s/related' // Location of related youtube videos
        ); 

        // All these settings can be changed on the fly using the $player_variables option in the video function
        var $player_variables = array( 
            'type'              => 'application/x-shockwave-flash', 
            'width'             => 624,  // Sets player width 
            'height'            => 369,  // Sets player height 
            'allowfullscreen'   => 'true', // Gives script access to fullscreen (This is required for the fs setting to work)
            'allowscriptaccess' => 'always' 
        ); 
         
        // All these settings can be changed on the fly using the $player_settings option in the video function
        var $player_settings = array( 
            'fs'          => true,  // Enables / Disables fullscreen playback 
            'hd'          => true,  // Enables / Disables HD playback (480p, 720p (Default), 1080p)
            'egm'         => false, // Enables / Disables advanced context (Right-Click) menu 
            'rel'         => false, // Enables / Disables related videos at the end of the video
            'loop'        => false, // Loops video once its finished 
            'start'       => 0,     // Start the video at X seconds 
            'version'     => 2,     // 3 = Chromeless Note: Chromeless player does not support the hd attribute at this time
            'autoplay'    => false, // Automatically starts video when page is loaded 
            'showinfo'    => false, // Enables / Disables information like the title before the video starts playing
            'disablekb'   => false, // Enables / Disables keyboard controls 
        ); 

        function getImage($video_id, $size = 'small', $options = array()) { 
            // Array of allowed image sizes () 
            $accepted_sizes = array( 
                'small'  => 'default', 
                'large'  => 0, 
                'thumb1' => 1, // Alternate small image 
                'thumb2' => 2, // Alternate small image 
                'thumb3' => 3  // Alternate small image 
            ); 
             
            // Build url to image file 
            $image_url = sprintf($this->api_links['image'], $video_id, $accepted_sizes[$size]); 
             
            // If raw is set to true in options return url only else return complete image
            if(isset($options['raw']) && $options['raw']){ 
                return $image_url; 
            }else{ 
                return $this->image($image_url, $options); 
            } 
        } 

        function video($video_id, $player_settings = array(), $player_variables = array()) {
            // Sets flash player settings if different than default 
            $this->player_settings = am($this->player_settings, $player_settings); 

            // Sets flash player variables if different than default 
            $this->player_variables = am($this->player_variables, $player_variables); 
             
            // Sets src variable for a valid object 
            $this->player_variables['src'] = sprintf($this->api_links['player'], $video_id, http_build_query($this->player_settings)); 

            // Returns embedded video 
            return $this->tag('object', 
                $this->tag('param', null, array('name' => 'movie',             'value' => $this->player_variables['src'])). 
                $this->tag('param', null, array('name' => 'allowFullScreen',   'value' => $this->player_variables['allowfullscreen'])). 
                $this->tag('param', null, array('name' => 'allowscriptaccess', 'value' => $this->player_variables['allowscriptaccess'])). 
                $this->tag('embed', null, $this->player_variables) 
            ,array( 
                'width'  => $this->player_variables['width'], 
                'height' => $this->player_variables['height'], 
                'data'   => $this->player_variables['src'], 
                'type'   => $this->player_variables['type'] 
            )); 
        } 
    } 
?>