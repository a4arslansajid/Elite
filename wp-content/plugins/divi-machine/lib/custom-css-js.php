<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function divi_machine_custom_css_js() {
  /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-machine' );*/

  $machine_custom_css= de_get_option_value('divi-machine', 'machine_custom_css'); //$titan->getOption( 'machine_custom_css' );
  $machine_custom_js = de_get_option_value('divi-machine', 'machine_custom_js'); //$titan->getOption( 'machine_custom_js' );

  // CUSTOM CSS

  if ($machine_custom_css != "" && $machine_custom_css != "0") {
    function divi_machine_custom_css_head()  {
      /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-machine' );*/
      $machine_custom_css = de_get_option_value('divi-machine', 'machine_custom_css'); //$titan->getOption( 'machine_custom_css' );
      $machine_custom_css_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $machine_custom_css );
      ?>
<style id="machine-custom-css-code"><?php echo $machine_custom_css_min ?></style>
      <?php
    }
    add_action( 'wp_head', 'divi_machine_custom_css_head' );
  }

  // CUSTOM JS
    remove_action( 'wp_footer', 'divi_machine_custom_js_footer', 10 );
    if ($machine_custom_js != "" && $machine_custom_js != "0") {
      function divi_machine_custom_js_footer()  {
        /*include(DE_DMACH_PATH . '/titan-framework/titan-framework-embedder.php');
          $titan = TitanFramework::getInstance( 'divi-machine' );*/
        $machine_custom_js = de_get_option_value('divi-machine', 'machine_custom_js'); //$titan->getOption( 'machine_custom_js' );
        ?>
  <!-- Machine custom JS -->
<?php echo $machine_custom_js ?>
        <?php
      }
      add_action( 'wp_footer', 'divi_machine_custom_js_footer' );
    }
}
add_action( 'init', 'divi_machine_custom_css_js', 1 );
?>
