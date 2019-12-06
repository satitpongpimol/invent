<?php
 class Application
 {
     private $_charset = 'iso-8859-1';

     private $_html;
     private $_css;
     private $_js;
     private $_meta;

     private $_doctype = '4';

     private $_meta_arr = array();
     private $_js_arr = array();
     private $_css_arr = array();

     public $title;

     public function __construct()
     {
         use_doctype_v4();
     }

     public function __destructor()
     {
         //  $this->_html = '';
        //  $this->_css = '';
        //  $this->_js = '';
        //  $this->_meta = '';

        //  unset($this->_meta_arr);
        //  unset($this->_mjs_arr);
        //  unset($this->_css_arr);
     }

     /**
      * release html document.
      */
     public function run()
     {
         $this->_html = '';
         $this->_css = '';
         $this->_js = '';
         $this->_meta = '';

         unset($this->_meta_arr);
         unset($this->_mjs_arr);
         unset($this->_css_arr);
     }

     /**
      * set html document support charecter set.
      *
      * @param [type] $charset
      */
     public function set_charset($charset)
     {
         $this->$_charset = $charset;
     }

     /**
      * set document title.
      *
      * @param [type] $title
      */
     public function set_title($title)
     {
         $this->title = $title;
     }

     public function use_doctype_v4()
     {
         $this->_doctype = <<<DOCTYPE
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
DOCTYPE;
         add_meta('<meta http-equiv="Content-Type" content="text/html; charset="'.$this->_charset.' />');
     }

     public function use_doctype_v5()
     {
         $this->_doctype = <<<DOCTYPE
         <!DOCTYPE html>
         <html>
         <head>
DOCTYPE;
     }

     public function add_meta($meta)
     {
         $this->_meta_arr[] = $meta;
     }

     public function add_js_text($jstext)
     {
         $this->$_js_arr['text'][] = $jstext;
     }

     public function add_js_files($file)
     {
         if (is_array($file)) {
             foreach ($file as $f) {
                 $this->$_js_arr['files'][] = $f;
             }
         } else {
             $this->$_js_arr['files'][] = $file;
         }
     }

     public function add_css_text($csstext)
     {
         $this->_css_arr['text'][] = $csstext;
     }

     public function add_css_files($cssfile)
     {
         if (is_array($file)) {
             foreach ($file as $f) {
                 $this->$_css_arr['files'][] = $f;
             }
         } else {
             $this->$_css_arr['files'][] = $file;
         }
     }

     public function get_meta_tag()
     {
         return $this->_meta;
     }

     public function get_js()
     {
         return $this->_js;
     }

     public function get_css()
     {
         return $this->_css;
     }

     private function get_html()
     {
         gen_html();

         return $this->_html;
     }

     public function begin_body()
     {
         echo get_html();
     }

     public function end_body()
     {
         echo '</body></html>';
     }

     private function gen_html()
     {
         $this->_html = <<<HTML
         {$this->_doctype}
HTML;
         gen_meta();
         gen_js();
         gen_css();

         $this->_html .= $this->_meta.PHP_EOL;
         $this->_html .= $this->_js.PHP_EOL;
         $this->_html .= $this->_css.PHP_EOL;
     }

     private function gen_meta()
     {
         foreach ($this->_meta_arr as $mata) {
             $this->_meta .= $mata.PHP_EOL;
         }
     }

     private function gen_css()
     {
         // gen link (css) file
         foreach ($this->_css_arr['files'] as $file) {
             $this->_html .= "<link href=\"{$file}\" rel=\"stylesheet\" />".PHP_EOL;
         }

         // gen css text
         $css_text = '<style type="text/css">'.PHP_EOL;
         foreach ($this->_css_arr['text'] as $text) {
             $css_text .= $text.PHP_EOL;
         }
         $css_text .= '</style>';
         $this->_css .= $css_text;
     }

     private function gen_js()
     {
         // gen javascript file
         foreach ($this->_js_arr['files'] as $file) {
             $this->_html .= "<script src=\"{$file}\" type=\"text/javascript\"></script>".PHP_EOL;
         }

         // gen javascript text
         $js_text = '<script type="text/javascript">'.PHP_EOL;
         foreach ($this->_js_arr['text'] as $text) {
             $js_text .= $text;
         }
         $js_text .= '</script>';
         $this->_js .= $js_text;
     }
 }
