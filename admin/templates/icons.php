<style type="text/css">
.iconmoon-row { display: flex; flex-wrap: wrap; margin-top: 20px; margin-bottom: 20px; }
.aa-iconmoon-items { padding: 10px; width: 100%; max-width: 4%; text-align: center; }
.aa-iconmoon-items:hover {
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
    background: #ffffff;
}
.iconmoon { font-size: 25px; display: block; margin-bottom: 10px; }
.iconmoon:before { color: #222222; }
.iconmoonname { display: block; }
.iconmoonwrap { 
    padding: 8px;
    height: 100%;
}
</style>

<div>
    <h3>Available Theme Icons</h3>

    <?php 

    $response = wp_remote_get( get_template_directory_uri() . '/assets/iconmoon/selection.json' );

    $json = wp_remote_retrieve_body( $response );

    $code = wp_remote_retrieve_response_code( $response );

    global $wp;

    $page = add_query_arg( $wp->query_vars, null );

    if( isset( $_GET['success'] ) ) {
        ?>
        <?php if( $_GET['success'] == 1 ): ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Success!</strong> icons files has been updated.</p>
            </div>
        <?php else: ?>
            <div class="notice notice-error is-dismissible">
                <p><strong>Error!</strong> invalid configuration file.</p>
            </div>
        <?php endif; ?>
        <script>window.history.replaceState(null, null, window.location.pathname+'?page=<?php echo $_GET['page']; ?>');</script>
        <?php
    }

    ?>

    <form action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>" style="margin: 20px 0;" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <input type="hidden" name="action" value="aa_iconmoon_import">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="submit" class="button" value="Import">
    </form>

    <?php

    if( $code === 200 ) {
        
        ?>

        <div class="notice notice-success is-dismissible">
            <p><strong>Icon's found!</strong> To add new icon <a href="<?php echo get_template_directory_uri() . '/assets/iconmoon/selection.json'  ?>" target="_blank" download>download</a> the json file and import to <a href="https://icomoon.io/" target="_blank">Iconmoon</a>.</p>
        </div>

        <?php

        $icons = json_decode( $json );

        $prefix = $icons->preferences->fontPref->prefix;

        ?><div class="iconmoon-row"><?php

        foreach( $icons->icons as $iconmoon ):

            ?>
            <div class="aa-iconmoon-items" data-icon="<?php echo $prefix.$iconmoon->properties->name; ?>">
                <div class="iconmoonwrap">
                    <span class="iconmoon <?php echo $prefix.$iconmoon->properties->name; ?>"></span>
                    <small class="iconmoonname"><?php echo $iconmoon->properties->name; ?></small>
                </div>
            </div>
            <?php

        endforeach;

        ?></div><?php


    } else {

        ?>

        <div class="notice notice-error">
            <p><strong>Icon not Found!</strong> please generate icon from <a href="https://icomoon.io/" target="_blank">Iconmoon</a> and import the zip file.</p>
        </div>

        <?php

    }

    ?>
</div>

<script>
    ( function( $ ) {
        $( '.aa-iconmoon-items' ).click( function() {
            var icon = $( this ).data('icon');
            alert( icon );
        });
    } )( jQuery );
</script>