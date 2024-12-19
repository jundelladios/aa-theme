<?php

/**
 * Columns Module Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Social Share Modal' ) )
->set_category( 'aa_blocks', __( 'American Accents', 'american-accennts-theme' ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'columnshtml' )
    ->set_html( '<h2>Social Share Modal</h2><p>To execute this share module you have to add an attribute to your element named aa-modal-share with the url. ex: aa-modal-share="'.home_url().'"</p>' ),

    Field::make( 'complex', 'socmed', __( 'Social Medias' ) )
    ->set_collapsed( true )
    ->set_layout( 'tabbed-horizontal' )
    ->add_fields( array(
        Field::make( 'select', 'media', __( 'Social Media Type' ) )->set_width( 50 )
        ->add_options( array(
            'fb' => 'Facebook',
            'twitter' => 'Twitter',
            'vk' => 'VK.com',
            'ok' => 'OK.ru',
            'mailru' => 'Mail.Ru',
            'gplus' => 'Google+',
            'googlebookmarks' => 'Google Bookmarks',
            'livejournal' => 'LiveJournal',
            'tumblr' => 'Tumblr',
            'pinterest' => 'Pinterest',
            'linkedin' => 'LinkedIn',
            'reddit' => 'Reddit',
            'weibo' => 'Weibo',
            'line' => 'Line.me',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'whatsapp' => 'Whatsapp',
            'viber' => 'Viber',
            'email' => 'Email'
        ) ),
        Field::make( 'color', 'color', __( 'Social Color' ) )->set_width( 50 ),
        Field::make( 'text', 'icon', __( 'Social Icon' ) )->set_width( 50 ),
        Field::make( 'text', 'label', __( 'Social Label' ) )->set_width( 50 ),
    ))
    ->set_header_template( ' <%- label %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    global $wp;
    ob_start();
    if(count($fields['socmed'])):
    ?>
        <div class="modal social-share-modal-module modal-dynamic-component" data-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width:300px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body pt-3 pb-5">
                        <?php foreach( $fields['socmed'] as $soc ): ?>
                        <button
                        data-type="<?php echo $soc['media']; ?>"
                        data-url="<?php echo home_url( $wp->request ); ?>"
                        class="btn d-block full-width text-left mb-2 text-light aa_social_share" style="background: <?php echo $soc['color']; ?>;">
                            <span class="icon <?php echo $soc['icon']; ?> mr-1"></span> <?php echo $soc['label']; ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    $html = ob_get_clean();
    echo apply_filters( 'the_content', $html );
});