        </div>
    </div>
    <footer>
        <div class="container gt">
            <div class="row">
                <div class="col-lg-3 col-md-6 footer-col">
                    <?php if( is_active_sidebar( 'aa_footer_1' ) ): ?>
                        <?php dynamic_sidebar( 'aa_footer_1' ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6 footer-col">
                    <?php if( is_active_sidebar( 'aa_footer_2' ) ): ?>
                        <?php dynamic_sidebar( 'aa_footer_2' ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6 footer-col d-none d-md-block">
                    <?php if( is_active_sidebar( 'aa_footer_3' ) ): ?>
                        <?php dynamic_sidebar( 'aa_footer_3' ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6 footer-col d-none d-md-block">
                    <?php if( is_active_sidebar( 'aa_footer_4' ) ): ?>
                        <?php dynamic_sidebar( 'aa_footer_4' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
<?php wp_footer(); ?>
</body>
</html>