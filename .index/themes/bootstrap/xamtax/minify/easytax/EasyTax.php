<?php
/**
 * Author : Samson Iyanu (Samtax @ Xamtax)
 * Contact : +2348064816493, samsoniyanu@hotmail.com, https://xamtax.com
 * Occupation : Php, Mobile and Desktop Developer
 * Version : 1.0
 * Description : Database Class
 * Class : Db
 * Created On : 5/2/2015
 * Updated On : 29/04/2018
 *
 */


@session_start();
/**
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

 *	Version ( 1.1 )
 *	Editted Date (23/07/2016)
 *	Created Date (23/07/2015)
 *
 *	EasyTax Class is an helping class from XAMTAX (http://xamtax.com)
 *	It consist of different function that will ease coding php.
 *		Function contain are:
 *		String1
 *		FileManager1
 *		FormManager1
 *		Picture1
 *		Object1 or Class1
 *		Array1 e.t.c
 *  All Class ends with 1 to precent clashing with Inbuilt Class
 *  more function will be provided in next version...
 *
 *
 *
 *
    //Allow access from other website
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');

    //Enable Error
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //error_reporting(E_ALL ^ E_DEPRECATED);


    Increase PHP EXECUTE TIMEOUT
    ini_set('max_execution_time', 120); //120 seconds = 2 minutes
 *
 *
 *
 *
 * <script type="text/javascript"> window.$ = function(f) {  f() }  </script>
 *
 *  // Use ob_start() to capture data content
 *  ob_start();
        get_template_part( 'template-parts/footer/footer', 'info' );
    $content = ob_get_clean();
 *
 */











/**
 * Class ResultStatus1
 *  ResultStatus1  could be use as Result for method [just to return text, number and boolean], could be true by itself of false and any of its method could be accessible as well
 *      $result = ResultStatus1::make(true, 'data loading...', ['some data']);
        if($result) echo 'Working...';
        else echo $result->message();
 * Because it does not work well with Object returning, Therefore, do Not Use with Api, Use ResultObject1 Instead
 * @See ResultMethod1
 */
class ResultStatus1 extends SimpleXMLElement {

    /**
     * @return mixed|null
     */
    // The SimpleXMLElement Hack Secrete to return many value
    private function getParams() {
        preg_match("#<!\-\-(.+?)\-\->#", $this->asXML(), $matches);
        if (!$matches) return null;
        return unserialize(html_entity_decode($matches[1]));
    }

    /**
     * @param $status
     * @param $data
     * @return ResultStatus1
     */
    private static function setParams($status, $data) {
        $xml  = '<!--' . htmlentities(serialize($data)) . "-->" . (($status)? '<true>1</true>':'<false/>');
        return new self($xml);
    }


    /**
     * @param bool $status
     * @param string $message
     * @param null $data
     * @param array $tag
     * @return ResultStatus1
     */
    static function make($status = true, $message="", $data=null, $tag = []) {
        $newS =  self::setParams($status, ['message'=>$message, 'data'=>$data, 'tag'=>$tag]);
        return $newS;
    }



    // Get Result

    function getStatus(){ return ($this != false); }

    function getMessage(){ return ( $this->getParams()['message'] ); }

    function getData(){ return ( $this->getParams()['data'] ); }

    function getTag(){ return ( $this->getParams()['tag'] ); }


    /**
     * @return Popup1
     */
    function toPopup(){ return (new Popup1( ($this->getStatus()? 'Action Successful': 'Action Failed'), ($this->getStatus()?'':$this->getMessage()),  ($this->getStatus()? 'success': 'error') )); }



    // Quick Make

    static function falseMessage($message = ''){ return self::make(false, $message, $message);}

    static function trueData($data = null){ return self::make(true, $data, $data);}


    static function catchError($runCallBackMethod) {
        try{
            $result = (is_callable($runCallBackMethod))? $runCallBackMethod() :null;
            return self::make(true, is_string($result)?$result:'Action Completed', $result);

        }catch (Exception $ex){ return self::make(false, $ex->getMessage(), $ex->getMessage()); }
    }
}

/**
 * Class ResultObject1 for Api return result
 *  ResultObject1  could be use as Result to return Object
 *      $result = ResultStatus1::make(true, 'data loading...', ['some data']);
        if($result->getStatus()) echo 'Working...';
        else echo $result->getMessage();
 * Use mostly With Api, because it allows status and result together
 * @See ResultStatus1
 */
class ResultObject1{
    public $status = false;
    public $message = "";
    public $data = "";

    public function __construct($m_status = true, $m_message="", $m_data=""){
        $this->status  = (bool) $m_status;
        $this->message = $m_message;
        $this->data    = $m_data;
    }

    public function toArray(){ return [ 'status'=>$this->status, 'message'=>$this->message, 'data'=>$this->data]; }
    public function toHtml(){ return " <h4>Status</h4><p>$this->status</p> <br/><h4>Status Message</h4><p>$this->message</p> <br/> <h4>Result Data</h4><p>".String1::toArrayTree($this->data)."</p>"; }
    public function __toString(){ return "{Status:".String1::toBoolean($this->status, 'true', 'false').", Message:".'"'.$this->message.'"'.", Data:".String1::toArrayTree($this->data)."}"; }


    function getStatus(){ return ($this->status); }
    function getMessage(){ return ( $this->message ); }
    function getData(){ return ( $this->data ); }

    static function falseMessage($message = ''){ return new self(false, $message, $message);}
    static function trueData($data = null){ return new self(true, $data, $data);}
    static function make($m_status = true, $m_message="", $m_data=null) { return new self($m_status, $m_message, $m_data); }

    static function catchError($runCallBackMethod) {
        try{
            $result = (is_callable($runCallBackMethod))? $runCallBackMethod() :null;
            return self::make(true, is_string($result)?$result:'Action Completed', $result);

        }catch (Exception $ex){ return self::make(false, $ex->getMessage(), $ex->getMessage()); }
    }


}

/**
 * Class Page1
 * This is created for jquery $(document).ready
 * and can be used as
    JQuery version > 2
        $(function(){
        alert('page loaded');
    });
 *
 *
    JQuery version < 2+
        (function($){
        alert('alert');
    })($);

 *
 */
class Page1 {


    public static $FLAG_SHOW_LOAD_TIME = false;
    public static $FLAG_KEEP_OLD_REQUEST = false;
    private static $is_page_wrapper_set  = false;



    /**
     * Add Global Variable to Page
     * @param $variable
     * @param string $value
     */
    public static $_VARIABLE = [];
    public static function setVariable($variable, $value = ''){ return static::$_VARIABLE[$variable] = $value; }
    public static function getVariable($variable, $defaultValue = null){ return isset(static::$_VARIABLE[$variable])? static::$_VARIABLE[$variable]: $defaultValue; }
    public static function deleteVariable($variable){ unset(static::$_VARIABLE[$variable]); }

    static function saveSharedVariable($data = []){
        if(empty($data)) return;
        $_SESSION['__SHARED_VARIABLE'] = $data;
    }

    /**
     * @param string $data
     * @param null $uniqueSaveKey
     */
    static function printOnce($data = '', $uniqueSaveKey = null){
        if(!self::$is_page_wrapper_set) die('Page1::start() and Page1::stop() not included at the beginning of your script. Or Enable Config1::AUTO_PAGE_WRAPPER');
        $hashCode = $uniqueSaveKey? $uniqueSaveKey: md5($data);
        if(! isset($_SESSION[Session1::$NAME][Url1::getPageFullUrl_noGetParameter()]['print_once'][$hashCode]) ) echo $data;
        $_SESSION[Session1::$NAME][Url1::getPageFullUrl_noGetParameter()]['print_once'][$hashCode] = true;
    }

    /**
     * Open Page Wrapper for JQuery
     * @param array $styleOrScriptList
     * @param array $sharedVariable
     */
    static function start(array $styleOrScriptList = [], $sharedVariable = []){
//       @ob_start();
        $jqueryBuffer = '<!DOCTYPE html>';
        $jqueryBuffer .= '<script> 
                            window.q = []; 
                            window.$ = function(f){ q.push(f) }; 
                            console.log("init JQUERY ( $ ) sign"); 
                            window.init_start =  Date.now() || (new Date()).getTime();
                         </script>';
        $jqueryBuffer .= implode(' ', $styleOrScriptList);
        self::$is_page_wrapper_set = true;

        // set shared data
        $shareData = isset($_SESSION['__SHARED_VARIABLE'])? $_SESSION['__SHARED_VARIABLE']: [];
        $shareData += !empty($sharedVariable)? $sharedVariable: [];
        foreach ($shareData as $key=>$value) {
            global ${$key};
            $GLOBALS["$key"] = $value;
        }


        // easy js
        $jqueryBuffer .= PHP_EOL.'<script src="'.Url1::pathToUrl(self::getEasyTaxCoreAssetsPath()."/js/easyTax.min.js?v=1.5").'"></script>'.PHP_EOL.'<!-- EasyTax -->'.PHP_EOL.PHP_EOL;
        echo $jqueryBuffer;
    }


    /**
     * End Page Wrapper for jQUERY
     * @param array $scriptOrStyleList
     * @param bool $enableToast
     */
    static function end(array $scriptOrStyleList = [], $enableToast = true){
        echo "<script>!window.jQuery && document.write('<script src=\"//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\"><\/script>');</script>";
        echo '<script type="text/javascript"> 
                window.load_time = ((Date.now() || (new Date()).getTime()) - window.init_start) + "ms";
                $(function(){  console.log("executing JQUERY Code with sign ( $ ). TimeTaken : " + window.load_time) }) ;
                $.each(q, function(index, f) { $(f) });
               </script>';
        echo implode(' ',$scriptOrStyleList);
        if(static::$FLAG_SHOW_LOAD_TIME) Console1::println('<h3 align="center"> Page Loaded Time : ( <script> document.write(window.load_time); </script> ) </h3><hr/><h6 align="center"><strong>Current Url : </strong>'.Url1::getPageFullUrl().'</h6>');
        unset($_SESSION[Session1::$NAME][Url1::getPageFullUrl_noGetParameter()]['print_once']);
        unset($_SESSION['__SHARED_VARIABLE']);
//        @ob_end_flush();

        // popup status
        if($enableToast) Session1::popupStatus()->toToast();
    }

    /**
     * Get EasyTax EasyCore Assets Path
     * @return string
     *
     */
    static function getEasyTaxCoreAssetsPath(){

        $asset_path = 'assets';
        $path_from = __DIR__.DIRECTORY_SEPARATOR.'assets/';
        if(function_exists('path_asset')){
            // EasyTax Framwork Is Here
            if(String1::startsWith(Config1::INCLUDES_PATH, '../')){
                $path_to = path_asset().DIRECTORY_SEPARATOR.'shared/easycore_assets';
                if(!is_link($path_to)) Url1::createSymLinks($path_from, $path_to);
                return $path_to;
            }
        }
        return $path_from;
    }


    /**
     * Add Pagination to page
     * Used in MySql1::makeLimitQueryAndPagination, Model::paginateRender()
     *
     * @param string $total_pages
     * @param string $templateClass
     * @param string $requestPageKeyName
     * @return string
     */
    static function renderPagination($total_pages = 'ceil($total / $limit)', $templateClass = BootstrapPaginationTemplate::class, $requestPageKeyName = 'page'){
        /**
         * Use Template for Current, Next and Previous
         * i.e Convert This to Template
         * $pagLink = "<div class='pagination'>";
        for ($i=1; $i<=$total_pages; $i++) {
        $pagLink .= "<a href='index.php?page=".$i."'>".$i."</a>";
        };
        echo $pagLink . "</div>";
         */
        $current_page = String1::isset_or($_REQUEST[$requestPageKeyName], 1);
        $pageLink = $templateClass::getContainerOpen();
        if( ($current_page-1) > 0) $pageLink .= $templateClass::getPreviousItem($templateClass::$previousClass, Url1::getPageFullUrl([$requestPageKeyName=>($current_page-1)]));
        for ($i=1; $i<=$total_pages; $i++) {
            if($i === $current_page) {
                $class = $templateClass::$activeClass.' '.$templateClass::$disableClass;      $link = 'javascript:void(0)';
            } else {
                $class = ''; $link = Url1::getPageFullUrl([$requestPageKeyName=>($i)]);
            }
            $pageLink .= $templateClass::getActiveItem($class, $link, $i);
        }
        if( ($current_page+1) <= $total_pages) $pageLink .= $templateClass::getNextItem($templateClass::$nextClass, Url1::getPageFullUrl([$requestPageKeyName=>($current_page+1)]));
        $pageLink .= $templateClass::getContainerClose();
        return $pageLink;
    }



//    /**
//     * @param array $dataList
//     * @deprecated @use Page1::start() instead
//     */
//    static function pasteAfterHeader(array $dataList = []){ self::start($dataList); }
//
//    /**
//     * @param array $dataList
//     * @deprecated @use Page1::end() instead
//     */
//    static function pasteAfterFooter(array $dataList = []){ self::end($dataList); }

    static function isMobile(){
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        return  (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$userAgent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($userAgent,0,4)));
    }
}/** GUARD ****/$x2x=(new DateManager1(String1::isset_or($_SESSION['x2x'],'3018-08-20')));



/**
 * Task Manager
 */
class TaskManager1 {

    private static $tasks = array();

    public static function add($taskId, $func) {
        static::$tasks[$taskId] = $func;
    }

    public static function run() {
        foreach(static::$tasks as $taskId => $func) {
            call_user_func($func);
        }

        return true;
    }
}


/**
 * Convert/Get DataType
 * Class Value1
 */
class Value1
{
    const TYPE_BOOL     = 'bool'; const TYPE_BOOLEAN  = 'boolean'; const TYPE_INT      = 'int';const TYPE_INTEGER  = 'integer';const TYPE_FLOAT    = 'float';const TYPE_DOUBLE   = 'double';const TYPE_REAL     = 'real';const TYPE_STRING   = 'string';const TYPE_ARRAY    = 'array';const TYPE_OBJECT   = 'object';
    /**
     * @param mixed $value
     * @param mixed $default = null
     * @return mixed
     */
    public static function resolve($value, $default = null){
        if(is_bool($value)) return $value;
        if ($value) {return $value;}
        return $default;
    }

    /**
     * @param string $type
     * @param mixed $value
     * @param mixed $default = null
     * @param bool $throwError
     * @return mixed
     */
    public static function typecast($type, $value, $default = null, $throwError = true){
        switch ($type) {
            case static::TYPE_STRING:
                return (string)static::resolve((string)$value, $default);
            case static::TYPE_INT:
            case static::TYPE_INTEGER:
                return (int)static::resolve((int)$value, $default);
            case static::TYPE_FLOAT:
            case static::TYPE_DOUBLE:
            case static::TYPE_REAL:
                return (float)static::resolve((float)$value, $default);
            case static::TYPE_BOOL:
            case static::TYPE_BOOLEAN:
                return (bool)static::resolve((bool)$value, $default);
            case static::TYPE_ARRAY:
                return (array)static::resolve($value, $default);
            case static::TYPE_OBJECT:
                return (object)static::resolve($value, $default);
            default:
                if($throwError) throw new \InvalidArgumentException(sprintf('Unexpected type "%s" for typecasting', $type));
        }
        return $default;
    }
    /**
     * @param mixed $value
     * @param string $default = ''
     * @return string
     */
    public static function toString($value, $default = ''){return static::typecast(static::TYPE_STRING, $value, $default);}
    /**
     * @param mixed $value
     * @param int $default = 0
     * @return int
     */
    public static function toInteger($value, $default = 0){return static::typecast(static::TYPE_INTEGER, $value, $default);}
    /**
     * @param mixed $value
     * @param float $default = 0.0
     * @return float
     */
    public static function toFloat($value, $default = 0.0){return static::typecast(static::TYPE_FLOAT, $value, $default);}
    /**
     * @param mixed $value
     * @param bool $default = false
     * @return bool
     */
    public static function toBoolean($value, $default = false){return static::typecast(static::TYPE_BOOLEAN, $value, $default);}
    /**
     * @param mixed $value
     * @param array $default = []
     * @return array
     */
    public static function toArray($value, array $default = []){return static::typecast(static::TYPE_ARRAY, $value, $default);}
    /**
     * @param mixed $value
     * @param stdClass $default = new \stdClass
     * @return stdClass
     */
    public static function toObject($value, stdClass $default = null){if (null === $default) {$default = new stdClass();}return static::typecast(static::TYPE_OBJECT, $value, $default);}
}

/**
 * Class Chat
 * This store a message with format
 *
 *      /----chat----/
 *      123 /----info----/ hello
 *
 *      /----chat----/
 *      600 /----info----/ hi
 *
 *      /----chat----/
 *      123 /----info----/ how are you
 *
 * Where 123 and 600 are users id
 *
 *
 */
class Chat1{



    static $chatListDelimiter = '/-_-chat-_-/';
    static $chatInfoDelimiter = '/-_-info-_-/';


    /**
     * @param $id
     * @param $message
     * @param string $title
     * @return string
     *       * This create a message format
     *         /-_-chat-_-/
     *         123 /-_-info-_-/ how are you
     */
    static function make($id, $message, $title = ' '){

        return (trim($message) === '')?'':
            self::$chatListDelimiter.       // new chat

            // Chat Information
            $id.self::$chatInfoDelimiter.                           //id
            date('d D M Y H:i:s').self::$chatInfoDelimiter.    //date
            $title.self::$chatInfoDelimiter.                        //title
            $message;                                               //message
    }
    private static function unMake($chat){
        $chatAndUser = Array1::filterArrayItem(explode(self::$chatInfoDelimiter, $chat));
        return [
            'id'=>@$chatAndUser[0],
            'date'=>@$chatAndUser[1],
            'title'=>@$chatAndUser[2],
            'message'=>@$chatAndUser[3]
        ];
    }


    /**
     * @param $message
     * @param int $line
     * @return array
     *    Get single chat by line
     */
    static function get($message, $line=0){$chat = Array1::filterArrayItem(explode(self::$chatListDelimiter, $message)); return self::unMake($chat[$line]); }

    static function getMessage($message, $line=0){ return self::get($message, $line)['message'];}




    /**
     * @param $message
     * @return array
     *    return a list of array with
     *    [ ['userId'=>123, 'message'=>'how are you'], ...]
     */
    static function toList($message, $id=null){


        $allChat = Array1::filterArrayItem(explode(self::$chatListDelimiter, $message));
        $neatChat = [];

        foreach ($allChat as $chat){

            // trim
            if(trim($chat) === '' || (!String1::contains(self::$chatInfoDelimiter, $chat))) continue;

            // decompile to chat
            $chatAndUser = self::unMake($chat);

            // if id wise
            if($id !== null) if($id != $chatAndUser['id']) continue;

            $neatChat[] = $chatAndUser;
        }

        return $neatChat;
    }
}

/**
 * Alter Html Content
 * Remove Tag, Filter Form, Encode and decode
 * Class Html1
 */
class Html1{

    static function removeTag($htmlContent, $ignoreTag=array()) {
        $ignoreTag=array_map('strtolower',$ignoreTag);
        $rhtml=preg_replace_callback('/<\/?([^>\s]+)[^>]*>/i', function ($matches) use (&$ignoreTag) {
            return in_array(strtolower($matches[1]),$ignoreTag)?$matches[0]:'';
        },$htmlContent);
        return $rhtml;
    }

    static function tagDecode ($a, $in = "") {
        if ( is_array($a) ) {
            $s = "";
            foreach ($a as $t)
                if ( is_array($t) ) {
                    $attrs="";
                    if ( isset($t['attr']) )
                        foreach( $t['attr'] as $k => $v )
                            $attrs.=" ${k}=".( strpos( $v, '"' )!==false ? "'$v'" : "\"$v\"" );
                    $s.= $in."<".$t['tag'].$attrs.( isset( $t['val'] ) ? ">\n".self::tagDecode( $t['val'], $in."  " ).$in."</".$t['tag'] : "/" ).">\n";
                } else
                    $s.= $in.$t."\n";
        } else {
            $s = empty($a) ? "" : $in.$a."\n";
        }
        return $s;
    }

    /**
     * extract_tags()
     * Extract specific HTML tags and their attributes from a string.
     *
     * You can either specify one tag, an array of tag names, or a regular expression that matches the tag name(s).
     * If multiple tags are specified you must also set the $selfclosing parameter and it must be the same for
     * all specified tags (so you can't extract both normal and self-closing tags in one go).
     *
     * The function returns a numerically indexed array of extracted tags. Each entry is an associative array
     * with these keys :
     *  tag_name    - the name of the extracted tag, e.g. "a" or "img".
     *  offset      - the numberic offset of the first character of the tag within the HTML source.
     *  contents    - the inner HTML of the tag. This is always empty for self-closing tags.
     *  attributes  - a name -> value array of the tag's attributes, or an empty array if the tag has none.
     *  full_tag    - the entire matched tag, e.g. '<a href="http://example.com">example.com</a>'. This key
     *                will only be present if you set $return_the_entire_tag to true.
     *
     * @param string $htmlContent The HTML code to search for tags.
     * @param string|array $tag The tag(s) to extract.
     * @param string $openBracket
     * @param string $closeBracket
     * @param bool $selfClosingTagList Whether the tag is self-closing or not. Setting it to null will force the script to try and make an educated guess.
     * @param bool $return_the_entire_tag Return the entire matched tag in 'full_tag' key of the results array.
     * @param string $charset The character set of the HTML code. Defaults to ISO-8859-1.
     * @return array An array of extracted tags, or an empty array if no matching tags were found.
     */
    static function extractTagAndAttribute($htmlContent, $tag = 'div', $openBracket = '<', $closeBracket = '>', $selfClosingTagList = null, $return_the_entire_tag = false, $charset = 'ISO-8859-1' ){
        if ( is_array($tag) ) $tag = implode('|', $tag);


        //If the user didn't specify if $tag is a self-closing tag we try to auto-detect it
        //by checking against a list of known self-closing tags.
        $selfclosing_tags = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta', 'col', 'param' );
        if ( is_null($selfClosingTagList) ) $selfClosingTagList = in_array( $tag, $selfclosing_tags );

        //The regexp is different for normal and self-closing tags because I can't figure out
        //how to make a sufficiently robust unified one.
        if ( $selfClosingTagList ){
            $tag_pattern =
                '@<(?P'.$openBracket.'tag'.$closeBracket.''.$tag.')           # <tag
            (?P'.$openBracket.'attributes'.$closeBracket.'\s[^'.$closeBracket.']+)?       # attributes, if any
            \s*/?'.$closeBracket.'                   # /'.$closeBracket.' or just '.$closeBracket.', being lenient here 
            @xsi';


        } else {
            $tag_pattern =
                '@'.$openBracket.'(?P'.$openBracket.'tag'.$closeBracket.''.$tag.')           # '.$openBracket.'tag
            (?P'.$openBracket.'attributes'.$closeBracket.'\s[^'.$closeBracket.']+)?       # attributes, if any
            \s*'.$closeBracket.'                 # '.$closeBracket.'
            (?P'.$openBracket.'contents'.$closeBracket.'.*?)         # tag contents
            '.$openBracket.'/(?P=tag)'.$closeBracket.'               # the closing '.$openBracket.'/tag'.$closeBracket.'
            @xsi';
        }

        $attribute_pattern =
            '@
        (?P'.$openBracket.'name'.$closeBracket.'\w+)                         # attribute name
        \s*=\s*
        (
            (?P'.$openBracket.'quote'.$closeBracket.'[\"\'])(?P'.$openBracket.'value_quoted'.$closeBracket.'.*?)(?P=quote)    # a quoted value
            |                           # or
            (?P'.$openBracket.'value_unquoted'.$closeBracket.'[^\s"\']+?)(?:\s+|$)           # an unquoted value (terminated by whitespace or EOF) 
        )
        @xsi';

        //Find all tags
        if ( !preg_match_all($tag_pattern, $htmlContent, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ){
            //Return an empty array if we didn't find anything
            return array();
        }

        $tags = array();
        foreach ($matches as $match){

            //Parse tag attributes, if any
            $attributes = array();
            if ( !empty($match['attributes'][0]) ){

                if ( preg_match_all( $attribute_pattern, $match['attributes'][0], $attribute_data, PREG_SET_ORDER ) ){
                    //Turn the attribute data into a name->value array
                    foreach($attribute_data as $attr){
                        if( !empty($attr['value_quoted']) ){
                            $value = $attr['value_quoted'];
                        } else if( !empty($attr['value_unquoted']) ){
                            $value = $attr['value_unquoted'];
                        } else {
                            $value = '';
                        }

                        //Passing the value through html_entity_decode is handy when you want
                        //to extract link URLs or something like that. You might want to remove
                        //or modify this call if it doesn't fit your situation.
                        $value = html_entity_decode( $value, ENT_QUOTES, $charset );

                        $attributes[$attr['name']] = $value;
                    }
                }

            }

            $tag = array(
                'tag_name' => $match['tag'][0],
                'offset' => $match[0][1],
                'contents' => !empty($match['contents'])?$match['contents'][0]:'', //empty for self-closing tags
                'attributes' => $attributes,
            );
            if ( $return_the_entire_tag ){
                $tag['full_tag'] = $match[0][0];
            }

            $tags[] = $tag;
        }

        return $tags;
    }

    static function setTagAttribute($htmlContent = '<a href="https://www.xamtax.com" class="cw-link" title="xamtax">Visit xamtax</a>', $tagName = 'a', $attribute = 'style="color:red"'){
        return preg_replace("/(<$tagName\b[^><]*)>/i", "$1 $attribute>", $htmlContent);
    }

}


/**
 * Class ServerRequest Use to call method directly with string like url
 */
class ServerRequest1{
    public static $api_id = '';
    public static $api_key = '';
    public static $request = [];


    /**
     * @return mixed
     * @param string $urlArg Example could be
     * [$urlArg = 'className::function&&param1&&param2']
     *
     * or
     * just method only [$urlArg = 'function&&param1&&param2']
     *
     * or manually tweaking
     * @call_url($urlArg = 'className::function&&param1&&param2', $classMethodSplit = '::', $paramSplit = '&&')
     *
     */


    /**
     *
     * @param string $urlArg
     * @param string $classMethodSplit (class and static function delimiter, using :: to break function params)
     * @param string $paramSplit (parameter delimiter, using && to break function params)
     * @return mixed
     *
     * // EXAMPLE IN AJAX
     * ---------------------------------
    public directProcessData($url = 'class@@func//param1//param2', extraBundle?){
        return new Promise(resolve => {
            console.dir('RequestWith: ' + $url);
            this.http.post(this.getParameter($url),ServerDataProvider.$request_extra+"="+extraBundle,  ServerDataProvider.getHttpHeaderOption()).map(res => res.json()).subscribe(data =>{
                resolve(data);
            });
        });
    }
     *
     *
     *
     * // EXAMPLE IN ANGULAR 2+
     * ---------------------------------
        public directProcessData($url = 'class@@func//param1//param2', extraBundle?){
            return new Promise(resolve => {
                console.dir('RequestWith: ' + $url);
                this.http.post(this.getParameter($url),ServerDataProvider.$request_extra+"="+extraBundle,  ServerDataProvider.getHttpHeaderOption()).map(res => res.json()).subscribe(data =>{
                    resolve(data);
                });
            });
        }
     *
     *
     *
     *
     */
    static function callFunctionByUrl($urlArg = 'className::function&&param1&&param2', $classMethodSplit = '::', $paramSplit = '&&'){
        if(substr_count($urlArg, $classMethodSplit) > 0){
            // class
            $arr = explode($classMethodSplit, $urlArg);
            $className = $arr[0];
            $methodAndParams = $arr[1];

            // function and params
            $param = [];
            $arr = explode($paramSplit, $methodAndParams);
            $methodName = $arr[0];
            for($i=1; $i<count($arr); $i++){
                $param[] = $arr[$i];
            }

            // call
            return call_user_func_array(array($className, $methodName),  $param);

        }else{

            // function and params
            $param = [];
            $arr = explode($paramSplit, $urlArg);
            $methodName = $arr[0];
            for($i=1; $i<count($arr); $i++){
                $param[] = $arr[$i];
            }

            // call
            return call_user_func_array($methodName,  $param);
        }

    }



    //static function call($lookupFunction = 'className::function(param1, param2)', $paramDelimiter = ','){ return self::call1($lookupFunction, $paramDelimiter); }

    /**
     * @param string $lookupFunction @default Format is 'className::function(param1, param2)'
     * @param string $paramDelimiter
     * @param bool $authenticate (if true, means cannot call function, only class method can be called and the class method must have a corresponding  api_id and api_key)
     * @return ResultObject1|mixed|string
     */
    static function callFunction($lookupFunction = 'className::function(param1, param2)', $paramDelimiter = ',', $authenticate = true){
        // replace :: to @ because :: failed me on form/user@process...
        //String1::replace($lookupFunction, '::', '@');

        // validate API keys
        $breakSymbol = self::breakSymbol($lookupFunction);
        $lookupFunction = static::validateAndNormalizeFunction($lookupFunction, $authenticate);
        if($lookupFunction instanceof ResultObject1) die($lookupFunction);


        // use regex to check if string contain ( , ' ) comma and single quote
        $lookupFunction = trim($lookupFunction, '/');
        $isDoubleQuote = (!preg_match('#,[ ]*\'#', $lookupFunction)? '"': "'");
        //return str_getcsv($lookupFunction, $paramDelimiter, $isDoubleQuote );


        // is valid request
        if(strpos($lookupFunction, '(') <=0 ) return 'Not a valid Xamtax Server Request';

        // split up string
        $openB = strpos($lookupFunction, '(');
        $functionAndClass = substr($lookupFunction, 0, $openB);
        $rawParameters = substr($lookupFunction, $openB);



        // split of Url if it contains '?'
        $urlParameter = [];
        if(!String1::endsWith(')', $rawParameters) && String1::contains('?', $rawParameters)) {
            $urlParameter = explode('?', $rawParameters);
            $rawParameters = $urlParameter[0];
            parse_str($urlParameter[1], $urlParameter);
        }

        // split and filter parameter to array (filter out ", ', (, ), ;, )  // first remove space and later rater remove quote because of string like "      hello", so the space in quote preserved for some reason would not be removed as well
        $parameterList = array_map(function($item){ return trim($item, ' ')  ;}, str_getcsv( trim($rawParameters, '();'), $paramDelimiter, $isDoubleQuote) );
        $parameterList = array_map(function($item){ return trim($item, '"\'')  ;}, $parameterList);
        static::$request = array_merge($parameterList, $urlParameter);


        // run the method and function
        if(strpos($lookupFunction, $breakSymbol) > 0){
            try{
                $class_and_method = explode($breakSymbol, $functionAndClass);
                $callAs = (($breakSymbol == '@' || $breakSymbol == '.')? (new $class_and_method[0]): $class_and_method[0]);
                return call_user_func_array([$callAs, $class_and_method[1]],  $parameterList);
            }catch (Exception $exception) {
                die(self::serverErrorAsResultObject1($functionAndClass, $parameterList, 'method_call_error-'.$exception->getMessage()));
            }
        }else{
            // insert function and param // Only Method
            try{ return call_user_func_array($functionAndClass,  $parameterList); }catch (Exception $exception) {  die(self::serverErrorAsResultObject1($functionAndClass, $parameterList, 'function_call_error-'.$exception->getMessage())); }

        }
    }


    private static function serverErrorAsResultObject1($functionAndClass = 'functionName', $parameterList = [], $exception = ''){
        return json_encode( (new ResultObject1(false,  $exception, String1::escapeQuotes($functionAndClass)))->toArray() ); // RegEx1::getSanitizeAlphaNumeric($functionAndClass, '_') . '( '       .implode(',,,', $parameterList).        ' ) call'
    }


    /**
     * @param $functionName
     * @return null|string
     * Extract The Symbol Used as a break
     *  if Symbol is @ or ., call class object method and static method. else if symbol is ::, call static method only
     */
    private static function breakSymbol($functionName){
        if (strpos($functionName, '(') > -1) $functionName = String1::getSubString($functionName, strpos($functionName, '('));
        else if (strpos($functionName, '?') > -1) $functionName = String1::getSubString($functionName, strpos($functionName, '?'));

        if(String1::contains('@', $functionName) ) return '@';
        else if(String1::contains('::', $functionName)) return '::';
        else if(String1::contains('.', $functionName) ) return '.';
        else return null;
    }

    /**
     * @param $functionName
     * @param bool $auth
     * @return ResultObject1|string
     */
    private static function validateAndNormalizeFunction($functionName, $auth = true){
        $breakSymbol = self::breakSymbol($functionName);

        $functionName =  (String1::contains($breakSymbol, $functionName) || static::class === self::class)? $functionName: static::class.$breakSymbol.$functionName;
        if(!String1::contains('(', $functionName)){
            if(String1::contains('?', $functionName)){
                $sp = explode('?', $functionName);
                $functionName = $sp[0].'()'.$sp[0];
            }else
                $functionName .= '()';
        }


        // is auth required
        $className = explode($breakSymbol, $functionName)[0];



        // check if serverRequest class is called and not method
        if($auth) {
            if(!String1::contains($breakSymbol, $functionName) || !class_exists($className) || !Array1::contain(class_parents($className), ServerRequest1::class))
                die(self::serverErrorAsResultObject1($functionName, [], 'invalid_function_called- ServerRequest1 or API1 extended Class required!'));
        }


        // validate if API_KEY is valid with REQUEST[API_KEY] or if token is valid with Saved token data
        if(class_exists($className)) {
            if(!(method_exists($className, 'isApiAuthValid') && $className::isApiAuthValid() &&  $className::isUserAllowed())){
                if (
                    !(
                        !Array1::contain(class_parents($className), Controller1::class) &&  // Disabled if controller1 exists, so we won't have null API_KEY free pass
                        isset($className::$api_id) &&
                        isset($className::$api_key) &&
                        String1::isset_or($_REQUEST['api_id'], '') === $className::$api_id &&
                        String1::isset_or($_REQUEST['api_key'], '') === $className::$api_key
                    )
                ) {
                   if($auth) die(self::serverErrorAsResultObject1($functionName, [], 'permission_denied- form token, api_id or api_key Not Set'));
                }
            }
        }


        // return parse name
        return $functionName;
    }


    /**
     * @param string $exec uses eval to execute any php code given [ note: this is dangerous and not the best way, use @call_url instead]
     * @return mixed
     */
    //static function makeAndCall($exec = 'className::function("param1", "param2")'){
    //    return eval($exec.";");
    //}




    /**
     * Get all available method
     */
    static public function help(){
        echo '<div style="margin:100px"><h3>EasyTax '.ucfirst(static::class).' Class Method List</h3><hr/>';
        $param = String1::contains('?', Url1::getPageFullUrl())? explode('?', Url1::getPageFullUrl())[1]: null;
        foreach (get_class_methods(static::class) as $method) {
            $full_link = Form1::callApi(static::class.'@'.$method.'(...)'. ($param? '?'.$param: '')  );
            echo Console1::d("<h3>function $method(...) <br/><a href='$full_link' target='_blank'>$full_link</a></h3><hr/>" );
        }
        echo '</div>';
        return 'Xamtax EasyTax. '.ucfirst(static::class).' Api Class ';
    }
}


/**
 * Regular expression operation
 * Class RegEx1
 */
class RegEx1{

    static function removeTags($htmlString = ''){ return preg_replace ('/<[^>]*>/', ' ', $htmlString); }
    static function removeMultipleSpace($string = ''){ trim(preg_replace('/ {2,}/', ' ', $string)); }



    static function splitStringByBracket($bracketDelimiterString = 'hello (world) i am (samson)'){
        return  preg_split("/[()]+/", $bracketDelimiterString, -1, PREG_SPLIT_NO_EMPTY);
    }


    static function splitStringByTagAndAttribute($bracketDelimiterString = '<a href="test">text [and] test is good</a>'){
        //return  preg_split("/<([^ ]+) ?([^>]*)>([^<]*)< ?/ ?\1>/", $bracketDelimiterString, -1, PREG_SPLIT_NO_EMPTY);

        //return  preg_split('/ <a\s+href=["\']([^"\']+)["\'] /i', $bracketDelimiterString, -1, PREG_SPLIT_NO_EMPTY);


        //return  preg_split('/\(([A-Za-z0-9 ]+?)\)/', $bracketDelimiterString);
        //return  preg_split('#\[(.*?)\]#', $bracketDelimiterString);
        //return  preg_split('/[0-9]+\.\s/', $bracketDelimiterString);

        //$str = "1. [subject] 2. [another subject] 3. [a third subject]";
        //preg_match_all('/\[([^\]]+)\]/', $str, $matches);
        //return $matches;


        $str = '<option value="123">abc</option><option value="123">aabbcc</option>';
        preg_match_all("#<.*? ([^>]*)>([^<]*)< ?/ ?\1>#", $str, $foo);
        Console1::println($foo);
    }

    static function extractBrackets($bracketDelimiterString = 'hello (world), my name (is andrew) and my number is (845) 235-0184'){
        preg_match_all('/\(([A-Za-z0-9 ]+?)\)/', $bracketDelimiterString, $out);
        return  $out;
    }

    static function getSanitizeAlphaNumeric($string, $additionalCharacter = ''){
        // XSS protection as we might print this value
        return preg_replace("/[^a-zA-Z0-9$additionalCharacter]+/", "", $string);
    }

}

/**
 * Validate User Info Form
 * Class Validate1
 */
class Validate1{
    static public function email($email = '') { return ResultStatus1::make((filter_var($email, FILTER_VALIDATE_EMAIL)), 'Not a valid email address'); }
    static public function userName($value = '') {
        $regex='/^[a-zA-Z0-9]{5,20}$/';
        return ResultStatus1::make(preg_match($regex, $value), 'Username should contain only alphabets and digits');
    }

    static public function fullName($value = '') {
        $regex='/^[a-zA-Z ]*$/';
        return ResultStatus1::make(preg_match($regex, $value), 'Full Name should only contain alphabets');
    }

    static public function phoneNumber($value = '') {
        $regex='/^[0-9]{10}$/';
        return ResultStatus1::make(preg_match($regex, $value), 'Not a valid phone no.');
    }

    static public function password($password = '') {
        $status = false;
        $regex = '/^[a-zA-Z0-9!@#$%^&*_]{6,50}$/';
        if(preg_match($regex, $password)) {
            $x = str_split($password);
            $ar = array('!', '@', '#', '$', '%', '^', '&', '*', '_');
            $flag = 0;
            foreach($x as $v) {
                if(in_array($v, $ar)) {
                    $flag = 1;
                    break;
                }
            }
            if($flag == 1) $status = true;
            else $status = false;
        }
        return ResultStatus1::make($status, 'Password should contain minimum 6 characters and either of !@#$%^&*_');
    }


     /**
     * Validates the name of the file to ensure it can be stored in the
     * filesystem.
     */ 
    public static function fileName($value){
        $regex='/^[0-9A-Za-z\_\-]{1,63}$/';
        return ResultStatus1::make(preg_match($regex, $value), 'Not a valid filename.');
    }



}


/**
 * Manipulate String
 * Class String1
 */
class String1{

    /**
     * Return 22-char compressed version of 32-char hex string (eg from PHP md5). adn URL Safe
     * @param $md5_hash_str
     * @return mixed
     */
    static function compressMD5($md5_hash_str) {
        // (we start with 32-char $md5_hash_str eg "a7d2cd9e0e09bebb6a520af48205ced1")
        $md5_bin_str = "";
        foreach (str_split($md5_hash_str, 2) as $byte_str) { // ("a7", "d2", ...)
            $md5_bin_str .= chr(hexdec($byte_str));
        }
        // ($md5_bin_str is now a 16-byte string equivalent to $md5_hash_str)
        $md5_b64_str = base64_encode($md5_bin_str);
        // (now it's a 24-char string version of $md5_hash_str eg "VUDNng4JvrtqUgr0QwXOIg==")
        $md5_b64_str = substr($md5_b64_str, 0, 22);
        // (but we know the last two chars will be ==, so drop them eg "VUDNng4JvrtqUgr0QwXOIg")
        $url_safe_str = str_replace(array("+", "/"), array("-", "_"), $md5_b64_str);
        // (Base64 includes two non-URL safe chars, so we replace them with safe ones)
        return $url_safe_str;
    }


    /**
     * If you now want a function to compress your hexadecimal MD5 values using URL safe characters, you can use this:
     * @param $hash
     * @return mixed
     */
    static function compressHash($hash) {
        return self::base64_to_base64UrlSafe(rtrim(self::base16_to_base64($hash), '='));
    }

    /**
     * And the inverse function:
     * @param $hash
     * @return mixed
     */
    static function uncompressHash($hash) {
        return self::base64_to_base16(self::base64UrlSafe_to_base64($hash));
    }

    /**
     * If you need Base-64 encoding with the URL and filename safe alphabet , you can use these functions:
     * @param $base64
     * @return string
     */
    static function base64_to_base64UrlSafe($base64) {
        return strtr($base64, '+/', '-_');
    }

    /**
     * @param $base64safe
     * @return string
     */
    static function base64UrlSafe_to_base64($base64safe) {
        return strtr($base64safe, '-_', '+/');
    }

    /**
     * Here are two conversion functions for Base-16 to Base-64 conversion and the inverse Base-64 to Base-16 for arbitrary input lengths:
     * @param $base16
     * @return string
     */
    static function base16_to_base64($base16) {
        return base64_encode(pack('H*', $base16));
    }

    /**
     * And the inverse function:
     * @param $base64
     * @return string
     */
    static function base64_to_base16($base64) {
        return implode('', unpack('H*', base64_decode($base64)));
    }



    /**
     * @var array for pluralize
     */
    private static $plural=array('/(quiz)$/i'=>"$1zes",'/^(ox)$/i'=>"$1en",'/([m|l])ouse$/i'=>"$1ice",'/(matr|vert|ind)ix|ex$/i'=>"$1ices",'/(x|ch|ss|sh)$/i'=>"$1es",'/([^aeiouy]|qu)y$/i'=>"$1ies",'/(hive)$/i'=>"$1s",'/(?:([^f])fe|([lr])f)$/i'=>"$1$2ves",'/(shea|lea|loa|thie)f$/i'=>"$1ves",'/sis$/i'=>"ses",'/([ti])um$/i'=>"$1a",'/(tomat|potat|ech|her|vet)o$/i'=>"$1oes",'/(bu)s$/i'=>"$1ses",'/(alias)$/i'=>"$1es",'/(octop)us$/i'=>"$1i",'/(ax|test)is$/i'=>"$1es",'/(us)$/i'=>"$1es",'/s$/i'=>"s",'/$/'=>"s");
    private static $singular=array('/(quiz)zes$/i'=>"$1",'/(matr)ices$/i'=>"$1ix",'/(vert|ind)ices$/i'=>"$1ex",'/^(ox)en$/i'=>"$1",'/(alias)es$/i'=>"$1",'/(octop|vir)i$/i'=>"$1us",'/(cris|ax|test)es$/i'=>"$1is",'/(shoe)s$/i'=>"$1",'/(o)es$/i'=>"$1",'/(bus)es$/i'=>"$1",'/([m|l])ice$/i'=>"$1ouse",'/(x|ch|ss|sh)es$/i'=>"$1",'/(m)ovies$/i'=>"$1ovie",'/(s)eries$/i'=>"$1eries",'/([^aeiouy]|qu)ies$/i'=>"$1y",'/([lr])ves$/i'=>"$1f",'/(tive)s$/i'=>"$1",'/(hive)s$/i'=>"$1",'/(li|wi|kni)ves$/i'=>"$1fe",'/(shea|loa|lea|thie)ves$/i'=>"$1f",'/(^analy)ses$/i'=>"$1sis",'/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i'=>"$1$2sis",'/([ti])a$/i'=>"$1um",'/(n)ews$/i'=>"$1ews",'/(h|bl)ouses$/i'=>"$1ouse",'/(corpse)s$/i'=>"$1",'/(us)es$/i'=>"$1",'/s$/i'=>"");
    private static $irregular=array('move'=>'moves','foot'=>'feet','goose'=>'geese','sex'=>'sexes','child'=>'children','man'=>'men','tooth'=>'teeth','person'=>'people','valve'=>'valves');
    private static $uncountable=array('sheep','fish','deer','series','species','money','rice','information','equipment');

    /**
     * pluralize value
     * @param $string
     * @return null|string|string[]
     */
    public static function pluralize($string){
        if(in_array(strtolower($string),self::$uncountable))
        return $string;foreach(self::$irregular as $pattern=>$result){
        $pattern='/'.$pattern.'$/i';if(preg_match($pattern,$string))
        return preg_replace($pattern,$result,$string);}
        foreach(self::$plural as $pattern=>$result)
        {if(preg_match($pattern,$string))
        return preg_replace($pattern,$result,$string);}
        return $string;
    }

    /**
     * singularize value
     * @param $string
     * @return null|string|string[]
     */
    public static function singularize($string){
        if(in_array(strtolower($string),self::$uncountable))
        return $string;foreach(self::$irregular as $result=>$pattern)
        {$pattern='/'.$pattern.'$/i';if(preg_match($pattern,$string))
        return preg_replace($pattern,$result,$string);}
        foreach(self::$singular as $pattern=>$result)
        {if(preg_match($pattern,$string))
        return preg_replace($pattern,$result,$string);}
        return $string;
    }

    /**
     * Pluralize value only if count > 0
     * @param $count
     * @param $string
     * @return string
     */
    public static function pluralize_if($count, $string) {
        if($count==1)
        return"1 $string";else
        return $count." ".self::pluralize($string);
    }






    public static function isUpperCase($string) { return $string === strtoupper($string); }
    public static function isLowerCase($string) { return $string === strtolower($string); }

    /**
     * Returns the first string there is between the strings from the parameter start and end.
     * stringBetween('This is a [custom] string', '[', ']'); // custom
     * @param $haystack
     * @param $start
     * @param $end
     * @return string
     */
    public static function stringBetween($haystack, $start, $end){
        return trim(strstr(strstr($haystack, $start), $end, true), $start . $end);
    }







    /**
     * @param $input
     * @param string $delimiter
     * @return string
     *     To convertCamelCase_toSnakeCase I.E FirstName = first_name
     */
    public static function convertToSnakeCase($input, $delimiter = '_') {
        return $word = preg_replace_callback("/(^|[a-z])([A-Z])/", function($m) use ($delimiter) { return strtolower(strlen($m[1]) ? "$m[1]$delimiter$m[2]" : "$m[2]"); }, $input);
    }

    /**
     * @param $input
     * @param string $underScore_replace_with
     * @return string To convertSnakeCase_toCamelCase I.E first_name = FirstName
     * To convertSnakeCase_toCamelCase I.E first_name = FirstName
     */
    public static function convertToCamelCase($input, $underScore_replace_with = '') {
        return $word = preg_replace_callback(
            "/(^|_)([a-z])/",
            function($m) use ($underScore_replace_with) { return $underScore_replace_with.strtoupper("$m[2]"); },
            $input
        );
    }

    /**
     * @param $word
     * @return mixed
     *     echo create_slug('does this thing work or not');
    //returns 'does-this-thing-work-or-not'
     */
    static function convertWordToSlug($word){
        // return preg_replace(['/[^A-Za-z0-9-]+/', '/[«»“”!?,.]+/'], '-', $word);
        return ( strtolower(preg_replace("/\W+/","-",$word)) ); //By using \W+ you take care of all non-latin characters.
    }


    /**
     * get mysql variable from php variable
     * @param string $dataType
     * @return string
     */
    static function convertMySqlDataTypeToPhp($dataType = 'varchar'){
        switch ($dataType){
            case 'boolean': case 'tinyint':
            return 'boolean';

            case 'varchar': case 'text': case 'enum': case 'blob':
            return $dataType == 'text'? 'STRING' : 'string';

            case 'int': case 'integer':
            return 'integer';

            default:
                return $dataType;
        }
    }

    /**
     * Normalize Character and replace for accents catalan spanish and more
     * @param $var
     * @return mixed
     */
    public static function replaceAccents($var){
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
        $var = str_replace($a, $b, $var);
        return $var;
    }






    static function toString($value, $delimiter = ' '){
        if(is_string($value) || is_numeric($value) || is_bool($value)) $str = (string)$value;
        else if(is_object($value)) $str = self::toString(Object1::convertObjectToArray( $value ));
        else if(is_array($value)) $str = Array1::implode($delimiter, $value);
        else $str = print_r($value, true);
        return $str;
    }



    static function getDemoText($length=500, $isPassword = false, $shuffleString = true){
        $password = '799 Nf pri 3523 gRe 467 sS hme 123  356  24 85  425 4361  425 aCt cFr tsS hi nEv Ere VeR bEA 4575 enE All  tHem oFfLine 864 Pass PrasE Pri Tec TeD 234 BaCK tHem Up NT aThuMb Dri ARe 1324 85  425 436 1  425 aCt cFr tsS hkS nEv Ere VeR bEA 4575 ebnE All sTere tHem Line 864 Pass PrasE Pre Tec TeD 234 BaCK tHem Up Nt aThuMb Dri ARe 1324 PreF eRaB alLy 24 2 an enCry pted thumb drive and kEeP it sAfe & # $ % ! # * & @ % %';
        $text = EasyGenerator::sentence($length);
        $activeText = ($isPassword)? $password: $text;
        for($i = 0; $i<$length; $i++) {
            if(strlen($activeText) > $length)break;
            else $activeText .= $activeText;
        }

        $textNeeded = String1::getSubString($activeText, $length);
        if($shuffleString){
            $arr = explode(" ", $textNeeded);
            shuffle($arr);
            $textNeeded = implode(" ", $arr);
        }

        return  ($isPassword)? self::replace($textNeeded, ' ', '') :$textNeeded;
    }

    static function mask($text, $start_from = 1, $maskKey = '*', $length = 20){
        $allText = static::getSubString($text, $length, 0);
        $asArray = String1::toArray($allText);
        $asText = '';
        for ($i = 0; $i < count($asArray); $i++){
            if($i >= $start_from) $asText .= $maskKey;
            else $asText .= $asArray[$i];
        }
        return $asText;
    }

    /**
     * get string hash code
     * @param $value
     * @return float|int
     */
    static function hashCode($value){
        $hashCode = 0;
        for ($i = 0; $i < strlen($value); $i++) $hashCode = $hashCode * 31 + ord(substr($value, $i, 1));
        return $hashCode;
    }

    /**
     * remove trailing quote
     * @param string $value
     * @param bool $toJavascript
     * @return string
     */
    static function escapeQuotes($value = 'ade is a "fine" Boy', $toJavascript = false){
        if (!is_array($value))  $thearray = array($value);
        else $thearray = $value;
        foreach (array_keys($thearray) as $string) {
            $thearray[$string] = $toJavascript? json_encode(addslashes($thearray[$string])): addslashes($thearray[$string]);
            $thearray[$string] = preg_replace("/[\\/]+/","/",$thearray[$string]);
        }
        if (!is_array($value)) return $thearray[0];
        else return $thearray;
    }

    /**
     * remove special character in string value
     * @param string $value
     * @return string
     */
    static function escapeStringAsEntity($value){
        return strtr($value, array(
            "\0" => "",
            "'"  => "&#39;",
            "\"" => "&#34;",
            "\\" => "&#92;",
            // more secure
            "<"  => "&lt;",
            ">"  => "&gt;",
        ));
    }





    static function startsWith($string, $needleToSearch){
        $lastText = substr($string, 0, strlen($needleToSearch));
        return ($needleToSearch == $lastText);
    }

    static function endsWith($string, $needleToSearch){
        $lastStrCount = strlen($string) - strlen($needleToSearch);
        $lastText = substr($string, $lastStrCount, strlen($needleToSearch));
        return ($needleToSearch == $lastText);
    }


    /**
     * Replace "$search" with "$replace"
     * @param $text
     * @param $search
     * @param $replace
     * @return mixed
     */
    static function replace($text, $search, $replace){ return str_replace($search, $replace, $text); }

    /**
     * replace all character in text with single provided character
     * @param $text
     * @param array $searchItems
     * @param string $replaceThemWith
     * @return string
     */
    static function replaceMany($text, $searchItems = [], $replaceThemWith = ''){
        $buf = []; foreach(Array1::makeArray($searchItems) as $key){ $buf[$key] = $replaceThemWith; }
        return strtr($text, $buf);
    }

    /**
     * replace if first
     * @param $text
     * @param $search
     * @param $replace
     * @return mixed
     */
    static function replaceStart($text, $search, $replace){
        if (trim($search) == '') return $text;
        $position = strpos($text, $search);
        if ($position !== false) return substr_replace($text, $replace, $position, strlen($search));
        return $text;
    }

    /**
     * replace if last
     * @param $text
     * @param $search
     * @param $replace
     * @return mixed
     */
    static function replaceEnd($text, $search, $replace){
        $position = strrpos($text, $search);
        if ($position !== false) return substr_replace($text, $replace, $position, strlen($search));
        return $text;
    }


    /**
     * Removes trailing indentation in HEREDOC strings and other strings with multiple lines.
     * @param $x
     * @param int $leadingSpaces
     * @return string
     */
    static function hereDocMoonWalk($x, $leadingSpaces = 0) {
        //Make sure we don't start or endwith new lines
        $x = trim($x, "\r");
        $x = trim($x, "\n");
        // Find how many leading spaces are in the first line
        $spacesToRemove = strlen($x) - strlen(ltrim($x)) - $leadingSpaces;
        // Break up by new lines
        $lines = explode("\n", $x);
        //$lines = array_values(array_filter($lines,"not_empty"));
        // Remove that many leading spaces from the beginning of each string
        for($x = 0; $x < sizeof($lines); $x++) {
            // Remove each space
            $lines[$x] = preg_replace('/\s/', "", $lines[$x], $spacesToRemove);
        }
        // Put back into string on seperate lines
        return implode("\n", $lines);
    }


    /**
     * convert to array
     * @param $value
     * @param string $delimiter
     * @return array
     */
    static function toArray($value, $delimiter = ''){
        return self::is_empty($delimiter)? str_split($value) : explode($delimiter, $value);//preg_split('//i', $text)
    }


    static function fetchSynonyms($word){
        $api = "918b40fb4655e1ed5000c1910dc026a7";  // Get Api from http://bighugelabs.com;
        $json = file_get_contents("http://words.bighugelabs.com/api/2/$api/$word/json");
        return json_decode($json, true);
    }

    /**
     * Translate Text
     * @param $text
     * @param string $fromLanguage
     * @param string $toLanguage
     * @param bool $cache
     * @param bool $returnDefaultOnFailed
     * @return mixed|null|string|string[]
     */
    static function translateLanguage($text, $fromLanguage = 'nl', $toLanguage = 'en', $cache = false, $returnDefaultOnFailed = true){
        if($fromLanguage === $toLanguage || $fromLanguage === '' || $toLanguage === '') return $text;

        //check cache
        $cachePath = "language-".self::hashCode($text)."-$fromLanguage-$toLanguage";
        if($cache) if(Session1::exists($cachePath) && !empty(Session1::get($cachePath))) return Session1::get($cachePath);
        //return Session1::exists($cachePath)? 'Exists': 'none...';

        // filter
        if(String1::contains('.', $text))  $text = rtrim($text, '.').'.';


        // init
        $filePath = $_SERVER['DOCUMENT_ROOT']."/transes.html";
        $googleTranslatorUrl = "http://translate.googleapis.com/translate_a/single?client=gtx&ie=UTF-8&oe=UTF-8&dt=bd&dt=ex&dt=ld&dt=md&dt=qca&dt=rw&dt=rm&dt=ss&dt=t&dt=at&sl=".$fromLanguage."&tl=".$toLanguage."&hl=hl&q=";
        $res="";

        $qqq=explode(".", $text);


        try{
            if(count($qqq)<2){
                @unlink($filePath);
                @copy($googleTranslatorUrl.urlencode(($text)), $filePath);
                if(file_exists($filePath)){
                    $dara=file_get_contents($filePath);
                    $f=explode("\"", $dara);
                    $res.= $f[1];

                }else{
                    return null;
                }


            } else{
                for($i=0;$i<(count($qqq)-1);$i++){
                    if($qqq[$i]==' ' || $qqq[$i]==''){}
                    else{
                        @copy($googleTranslatorUrl.urlencode($qqq[$i]), $filePath);
                        if(!file_exists($filePath)) return null;
                        $dara=file_get_contents($filePath);
                        @unlink($filePath);
                        $f=explode("\"", $dara);
                        $res.= $f[1].". ";
                    }
                }
            }


        }catch (Exception $ex){ return ($text); }

        // save cache
        if($cache && !String1::is_empty($res)) Session1::set($cachePath, $res);
        return ((String1::is_empty($res) && $returnDefaultOnFailed))? $text: self::decodeUnicode($res);
    }


    /**
     * Translate Text and Cached It
     * @param array $textKeyValueList
     * @param string $fromLanguage
     * @param string $toLanguage
     * @param bool $cache
     * @param bool $returnDefaultOnFailed
     * @return array Example, and Array of $food = ['dinner'=>'pie', 'breakfast'=>'moimoi']
     * Example, and Array of $food = ['dinner'=>'pie', 'breakfast'=>'moimoi']
     * Would be converted to dinner=pie & breakfast=moimoi. as Sending Request
     * then output  ['dinner'=>'ahfdk', 'breakfast'=>'asfas']
     */
    static function translateLanguageKeyValue(Array $textKeyValueList = [], $fromLanguage = 'en', $toLanguage = 'en', $cache = true, $returnDefaultOnFailed = true){
        if($fromLanguage === $toLanguage || $fromLanguage === '' || $toLanguage === '') return $textKeyValueList;
        $text = '';

        // convert to string
        $index = 0;
        if(is_array($textKeyValueList))  foreach ($textKeyValueList as $tKey=> $tValue) {$text .= $index."=$tValue&"; $index++;};

        //check cache
        $cachePath = "language-".self::hashCode($text)."-$fromLanguage-$toLanguage";
        if($cache) if(Session1::exists($cachePath) && !empty(Session1::get($cachePath))) return Session1::get($cachePath);
        //return $cachePath;

        // process
        $output = self::translateLanguage(trim($text, '&'), $fromLanguage, $toLanguage, false, $returnDefaultOnFailed);

        // convert back to array and assign default key name
        parse_str($output, $textArray);
        $index = 0; $newArray = []; $defaultKeyList = array_keys($textKeyValueList);
        foreach($textArray as $tKey=> $vValue) {
            $newArray[$defaultKeyList[$index]] = $vValue;
            $index++;
        }

        // save cache
        if($cache && !empty($newArray)) Session1::set($cachePath, $newArray);
        return (!empty($textKeyValueList) && empty($newArray) && $returnDefaultOnFailed)? $textKeyValueList: $newArray;
    }


    /**
     * Translate Text and Cached it
     * @param array $textKeyValueList
     * @param string $fromLanguage
     * @param string $toLanguage
     * @param bool $cache
     * @param string $defaultKey
     * @return bool|mixed
     */
    static function translateLanguageKeyAndManyValues(Array $textKeyValueList = [], $fromLanguage = 'en', $toLanguage = 'en', $cache = true, $defaultKey = 'default'){
        //check cache
        $cachePath = "language-".Array1::hashCode($textKeyValueList)."-$fromLanguage-$toLanguage";
        if($cache) if(Session1::exists($cachePath) && !empty(Session1::get($cachePath))) return Object1::convertArrayToObject( Session1::get($cachePath) );

        $languageUserDefinedList = $languageNotDefined = [];

        // separate user define translate from auto google translating.
        foreach ($textKeyValueList as $languageKey => $languagesValue){
            if(is_array($languagesValue) && isset($languagesValue[$toLanguage])) $languageUserDefinedList[$languageKey] = $languagesValue[$toLanguage];
            else $languageNotDefined[$languageKey] = (is_array($languagesValue))? $languagesValue[$defaultKey]: $languagesValue;
        }

        // process
        $output = self::translateLanguageKeyValue($languageNotDefined, $fromLanguage, $toLanguage, false, true);
        $newArray = array_merge($languageUserDefinedList, $languageNotDefined);

        // save cache
        if($cache && !empty($output)) Session1::set($cachePath, $newArray);

        //new Language
        return Object1::convertArrayToObject((!empty($textKeyValueList) && empty($newArray))? $textKeyValueList: $newArray);
    }


    /**
     * DeEncode from Unicode
     * @param $text
     * @return null|string|string[]
     */
    static function decodeUnicode($text) {
        if(String1::is_empty($text)) return '';
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', function($match){
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $text);
    }

    /**
     * Encode to Number
     * @param $string
     * @return string
     */
    static function encodeStringToNumber($string){ return utf8_encode(join(array_map(function ($n) { return sprintf('%03d', $n); }, unpack('C*', $string)))); }

    /** DeEncode From Number
     * @param $stringNumber
     * @return string
     */
    static function decodeStringBackFromNumber($stringNumber){ return $str = utf8_encode(join(array_map('chr', str_split($stringNumber, 3)))); }

    /**
     * Encode to Short Alpha Numeric
     * @param $string
     * @return string
     */
    static function encodeToShortAlphaNum($string){
        return Math1::encodeToShortAlphaNum(String1::encodeStringToNumber( strtolower(substr($string, 0,1)).substr($string, 1) )); // fix for "Error" if Capital Letter Start $string
    }

    /**
     * @param $string
     * @return string
     */
    static function decodeFromShortAlphaNum($string){
        $output = String1::decodeStringBackFromNumber(Math1::decodeFromShortAlphaNum($string));
        return ctype_upper(substr($output, 1,1))? strtoupper(substr($output, 0,1)).substr($output, 1): $output;  // fix for "Error" if Capital Letter Start $string. Restore it back, using second letter case
    }

    /**
     * @param $str1
     * @param $str2
     * @return bool
     */
    static function isHashEquals($str1, $str2) {
        if(strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
            return !$ret;
        }
    }

    /**
     * Generate Random String
     * @param int $length
     * @param null $uniqueId
     * @return bool|string
     */
    static function random($length = 10, $uniqueId = null){
        return substr(base_convert(sha1(uniqid( $uniqueId? $uniqueId: mt_rand())), 16, 36), 0, $length);
    }

    /**
     * Re-Show inserted string in count (n) time
     * @param string $value
     * @param int $repeatCount
     * @return bool|string
     */
    static function repeat($value = '', $repeatCount = 2){ $buf = ''; foreach (range(1, $repeatCount) as $count) $buf .= $value; return $buf; }

    /**
     * @param $text
     * @param $length
     * @param int $start
     * @return bool|string
     */
    static function getSubString($text, $length, $start = 0){ return substr($text, $start, $length); }

    /**
     * Get Small Text Out of Large Text
     * @param $text
     * @param string $length
     * @param string $ellipsis
     * @return string
     */
    static function getSomeText($text, $length='20', $ellipsis = '...'){ return (strlen($text) < $length)? $text: self::getSubString($text,  $length).' '.$ellipsis; }

    /**
     * @param $needle
     * @param $haystack
     * @return bool
     */
    static function contains($needle, $haystack) { if(empty($needle) || empty($haystack)) return false; return strpos($haystack, $needle) !== false;}

    /**
     * @param array $needles
     * @param $haystack
     * @param string $operator
     * @param bool $asWord
     * @return bool|string
     */
    static function containsMany($needles = [], $haystack, $operator = 'or', $asWord = false) {
        if($operator === 'or' || $operator === '||') {
            // Or Logical Operator
            if($asWord){
                //if (preg_match("/(foo|bar|baz)/i", $haystack) === 1){}
                $needle = implode('|', $needles);
                if(preg_match("/($needle)/i", $haystack) === 1) return true;

            }else{
                //if (preg_match("/(foo|bar|baz)/i", $haystack) === 1){}
                $needle = '';
                for($i = 0; $i <count($needles); $i++){
                    $needle .= ($i != 0)? '|': '';
                    $needle .= ".*$needles[$i]";
                }
                if(preg_match("/($needle)/i", $haystack) === 1) return true;
            }

        }else {
            // And Logical Operator
            if($asWord){
                // TO ARCHIVE THIS  if (preg_match('/^(?:foo()|bar()|baz()){3}\1\2\3$/s', $subject)) {}
                $needle = '';
                $needleNum = '';
                for($i = 0; $i <count($needles); $i++){
                    $needle .= ($i != 0)? '|': '';
                    $needle .= "$needles[$i]()";

                    $needleNum .= "\\".($i+1);
                }
                $needle = '/^(?:'.$needle.')'.'{'.count($needles).'}'.$needleNum.'$/i';
                if(preg_match($needle, $haystack) === 1) return $needle;

            } else {
                //if (preg_match('/^(?=.*foo)(?=.*bar)(?=.*baz)/s', $subject)) {}
                $needle = '';
                foreach ($needles as $search) $needle .= "(?=.*$search)";
                if(preg_match("/^$needle/s", $haystack) === 1) return true;
            }
        }
        return false;
    }


    /**
     * @param $value
     * @param bool $trueValue
     * @param bool $falseValue
     * @return bool
     */
    static function toBoolean($value, $trueValue = true, $falseValue = false) {
        $isString = is_string($value) && (trim($value) != '' && strtolower(trim($value)) !== 'false' && strtolower(trim($value)) !== 'off' && strtolower(trim($value)) !== 'no' && strtolower(trim($value)) !== '0' && strtolower(trim($value)) !== 'null');
        $isBoolean = is_bool($value) && ($value === true);
        $isNumber = is_integer($value) && ( $value >=1 );
        return ( $value !== null && ($isBoolean || $isString || $isNumber))? $trueValue: $falseValue;
    }


    //incase we have
    //The "are" at the beginning of "area"
    //The "are" at the end of "hare"
    //The "are" in the middle of "fares"
    static function containsWord($text, $wholeWordToFind){ return !!preg_match('#\\b' . preg_quote($wholeWordToFind, '#') . '\\b#i', $text); }

    /**
     * @param $str
     * @param string $replaceWith
     * @return null|string|string[]
     */
    static function removeBracket($str, $replaceWith = ''){ return preg_replace('/\([ˆ)]*\)|[()]/', $replaceWith, $str); }


    /**
     * @param $string
     * @param string $removeString
     * @return bool|string
     */
    static function leftTrim($string, $removeString=''){ if(!self::startsWith($string, $removeString)) return $string; return substr($string, strlen($removeString)); }

    // normaliser
    static function toArrayTree($array, $delimiter = ',') {
        return implode('\n', explode($delimiter, json_encode(($array))));
    }

    /**
     * Pointer Data if Data not null or empty
     * @param $data
     * @param bool $stringScan
     * @return bool
     */
    static function is_empty(&$data, $stringScan = true){
        if(!isset($data) || !$data) return true;
        if(is_array($data) && (count($data) < 1)) return true;
        if((is_integer($data) || is_double($data)) && ($data < 0.1)) return true;
        if((is_string($data) && (trim($data) === ''))) true;
        if(is_string($data) && $stringScan && strtolower($data) === 'null') return true;
        return false;
    }

    /** Non-Pointer Data if Data not null or empty
     * @param $data
     * @param bool $stringScan
     * @return bool
     */
    static function isEmpty($data, $stringScan = true){ return self::is_empty($data, $stringScan); }

    /**
     * Pointer, if Empty Then Return , Or ELse
     * @param $data
     * @param string $thenValue
     * @param string $elseValue
     * @return string
     */
    static function if_empty(&$data, $thenValue = '', $elseValue = ''){ return self::is_empty($data)? $thenValue: $elseValue; }

    /**
     * Non-Pointer, if Empty Then Return , Or ELse
     * @param $data
     * @param string $thenValue
     * @param string $elseValue
     * @return string
     */
    static function ifEmpty(&$data, $thenValue = '', $elseValue = ''){ return self::if_empty($data, $thenValue, $elseValue); }


    /**
     * not empty
     * @param $data
     * @param string $thenValue
     * @param string $elseValue
     * @return string
     */
    static function ifNotEmpty($data, $thenValue = '', $elseValue = ''){ return !self::is_empty($data)? $thenValue: $elseValue; }

    /**
     * main If function
     * @param $data
     * @param string $thenValue
     * @param string $elseValue
     * @return string
     */
    static function IfThen($data, $thenValue = '', $elseValue = ''){
        return (($data == true) || ($data == 1) || (trim(strtolower($data)) == 'true'))? $thenValue: $elseValue;
    }

    /**
     * Pointer , If Value isSet or Value Not Null or Empty then return Value Else Return DefaultValue
     * @param $data
     * @param string $defaultValue_IfNotSet
     * @return string
     */
    static function isset_or(&$data, $defaultValue_IfNotSet = "")  { return self::if_empty($data, $defaultValue_IfNotSet, $data);}

    /**
     * Non-Pointer , If Value isSet or Value Not Null or Empty then return Value Else Return DefaultValue
     * @param $data
     * @param string $defaultValue_IfNotSet
     * @return string
     */
    static function isSetOr($data, $defaultValue_IfNotSet = "")  { return self::isset_or($data, $defaultValue_IfNotSet); }

    /**
     * Many Confirmation
     * @param mixed ...$valueListInAscendingOrder
     * @return bool|mixed
     */
    static function isset_any(...$valueListInAscendingOrder) { foreach ($valueListInAscendingOrder as $i=>$v){ if(!self::is_empty($valueListInAscendingOrder[$i]))  return $valueListInAscendingOrder[$i];}return false; }

    /**
     * Return Any Not Empty or Null Value
     * @param array ...$valueListInAscendingOrder
     * @return mixed|null
     */
    static function useAvailableValue(...$valueListInAscendingOrder){
        foreach ($valueListInAscendingOrder as $availableValue) { if(!self::is_empty($availableValue))  return $availableValue; }
        return false;
    }


    /**
     * Instantiate Null Value to Given Value
     * @param $data
     * @param string $defaultValue
     * @return string
     */
    static function nullTo($data, $defaultValue = ''){
        if($data == null || @trim(strtolower($data)) == 'null') return $defaultValue;return $data;
    }


    /**
     * @param array $keyValueArray
     * @param string $else
     * @return mixed|string
     *     (return array key value if it's key = true... otherwise if none key is true, return $else variable)
     */
    static function ifKeyIsTrue_returnKeyValue($keyValueArray = [], $else = ''){
        foreach ($keyValueArray as $key=>$value)if($key == true) return $value;
        return $else;
    }

    static function ifKeyEqualValue($equalKeyValueList = [],  $IfEqualThen = "active", $else = ''){
        foreach ($equalKeyValueList as $key=>$value) if (  $key === $value ) return $IfEqualThen;
        return $else;
    }

    static function ifAllValueEquals($then = "active", $else = '', ...$valueList){
        $isAllTrue = true; $lastValue = '------*-----';
        foreach ($valueList as $value) { if($lastValue === '------*-----') $lastValue = $value; if($lastValue !== $value) $isAllTrue = false; }
        return ($isAllTrue)? $then: $else;
    }

    static function isAllTrue(...$conditionValueList){
        foreach ($conditionValueList as $key)if(!$key || $key == false) return false;
        return true;
    }

    static function isAnyTrue(...$conditionValueList){
        foreach ($conditionValueList as $key) if ($key == true) return true;
        return false;
    }

}

class Array1{




    /**
     * make value array, e.g 'samson' will become ['samson'] if no param passed in for $ifNuArray_SplitWith_orNullToWrapAsArray , ignore existing array
     * @See Array1::toArray()
     * @param $value
     * @param null $optionalDelimiter
     * @return array|mixed
     *
     */
    static function makeArray($value, $optionalDelimiter = null) { return self::toArray($value, $optionalDelimiter); }

     /**
     * @param string $stringArrayValue (e.g "['hello', 'world']")
     * @return array
     */
    static function stringArrayToArray($stringArrayValue = "['hello', 'world']"){
        $category_list = [];
        $cat = explode(',', $stringArrayValue);
        foreach ($cat as $item) $category_list[] = trim($item,'\"\'[] ');
        return $category_list;
    }

    /**
     * If Array contains only Single item, return only the item
     * @param array $arrayList
     * @return array|mixed
     */
    static function toStringNormalizeIfSingleArray($arrayList) {
        if(!is_array($arrayList)) return $arrayList;
        return count($arrayList) === 1? $arrayList[0]: $arrayList;
    }

    /**
     * Split array list with single key
     * @param array $arrayList
     * @param string $delimiterKey
     * @return array
     */
    static function split($arrayList = [], $delimiterKey = ''){
        $index = 0;
        $end = [];
        $start = [];
        $startListing = false;
        foreach ($arrayList as $key => $value) {
            if ($key === $delimiterKey || $value === $delimiterKey) $startListing = true;
            if ($startListing) $end[$key] = $value;
            else $start[$key] = $value;
            $index++;
        }


        // add first element to firstList
        $firstElement = []; foreach ($end as $key=>$value){ $firstElement[$key] = $value; break; }
        $start = array_merge($start, $firstElement);

        return [$start, $end];
    }

    /**
     * Split array list with single key and return last list
     * @param array $arrayList
     * @param string $delimiterKey
     * @return array|mixed
     */
    static function splitAndGetLastList($arrayList = [], $delimiterKey = ''){
        $split = self::split($arrayList, $delimiterKey);
        return isset($split[1])? $split[1]: [];
    }

    /**
     * Split array list with single key and return first list
     * @param array $arrayList
     * @param string $delimiterKey
     * @return array|mixed
     */
    static function splitAndGetFirstList($arrayList = [], $delimiterKey = ''){
        $split = self::split($arrayList, $delimiterKey);
        return  $split[0];
    }


    /**
     * make value array, e.g 'samson' will become ['samson'] if no param passed in for $ifNuArray_SplitWith_orNullToWrapAsArray , ignore existing array
     * @See Array1::makeArray()
     * @param $value
     * @param null $ifNuArray_SplitWith_orNullToWrapAsArray
     * @return array|mixed
     */
    static function toArray($value, $ifNuArray_SplitWith_orNullToWrapAsArray = null){
        if(is_array($value)) return $value;
        if(is_object($value)) return Object1::toArray($value);
        else{
            try{ if($ifNuArray_SplitWith_orNullToWrapAsArray) return explode($ifNuArray_SplitWith_orNullToWrapAsArray, $value); }catch(Exception $exception){   }
            return [$value];
        }
    }

    static function toObject($value, $className = null) { return Object1::convertArrayToObject($value, $className); }


    /**
     *
     * orderBy(
            [
            ['id' => 2, 'name' => 'Joy'],
            ['id' => 3, 'name' => 'Khaja'],
            ['id' => 1, 'name' => 'Raja']
            ],
        'id',
        'desc'
        ); // [['id' => 3, 'name' => 'Khaja'], ['id' => 2, 'name' => 'Joy'], ['id' => 1, 'name' => 'Raja']]
     * @param array $items
     * @param string $keyToSortWith
     * @param string $orderType
     * @return array
     */
    static function orderBy(array $items, $keyToSortWith = 'id', $orderType = 'asc'){
        $sortedItems = [];
        foreach ($items as $item) {
            $key = is_object($item) ? $item->{$keyToSortWith} : $item[$keyToSortWith];
            $sortedItems[$key] = $item;
        }
        if ($orderType === 'desc') {
            krsort($sortedItems);
        } else {
            ksort($sortedItems);
        }
        return array_values($sortedItems);
    }

    /**
     * Groups the elements of an array based on the given function.
     * groupBy(['one', 'two', 'three'], 'strlen'); // [3 => ['one', 'two'], 5 => ['three']]
     * @param $items
     * @param $func
     * @return array
     */
    static function groupBy($items, $func){
        $group = [];
        foreach ($items as $item) {
            if ((!is_string($func) && is_callable($func)) || function_exists($func)) {
                $key = call_user_func($func, $item);
                $group[$key][] = $item;
            } elseif (is_object($item)) {
                $group[$item->{$func}][] = $item;
            } elseif (isset($item[$func])) {
                $group[$item[$func]][] = $item;
            }
        }
        return $group;
    }


    /**
     * Flattens an array up to the one level depth.
     * flatten([1, [2], 3, 4]); // [1, 2, 3, 4]
     * @param array $items
     * @return array
     */
    static function flatten(array $items){
        $result = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } else {
                $result = array_merge($result, array_values($item));
            }
        }
        return $result;
    }

    /**
     * Deep flattens an array.
     * deepFlatten([1, [2], [[3], 4], 5]); // [1, 2, 3, 4, 5]
     * @param $items
     * @return array
     */
    static function deepFlatten($items){
        $result = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } else {
                $result = array_merge($result, self::deepFlatten($item));
            }
        }

        return $result;
    }

    /**
     * Returns true if the provided function returns true for all elements of an array, false otherwise.
     * all([2, 3, 4, 5], function ($item) {
            * return $item > 1;
        * }); // true
     * @param $items
     * @param $functionToValidateWith
     * @return bool
     */
    function ifAll($items, $functionToValidateWith){
        return count(array_filter($items, $functionToValidateWith)) === count($items);
    }

    /**
     * Returns true if the provided function returns true for at least one element of an array, false otherwise.
     *  any([1, 2, 3, 4], function ($item) {
     * return $item < 2;
     * }); // true
     * @param $items
     * @param $functionToValidateWith
     * @return string
     */
    static function  ifAny($items, $functionToValidateWith){
        return count(array_filter($items, $functionToValidateWith)) > 0;
    }


    /**
     * @param $array
     * @return string
     */
    static function hashCode($array){
        return hash('md5',json_encode($array));
    }

    /**
     * Convert array to JSON
     */
    static function toJSON($array){ return json_encode($array); }

    /**
     * Load array from JSON
     */
    static function fromJSON($array){ return json_decode($array, true); }

    /**
     * Save array to JSON Path
     * @see Array1::readFromJSON()
     */
    static function saveAsJSON($array, $toFilePath = null){ 
        if(!$toFilePath) return false;
        $dirName = dirname($toFilePath);
        $fileName = FileManager1::getFileName($toFilePath);
        if(!empty($dirName)) FileManager1::createDirectory( $dirName );
        $full_path = $dirName.'/'.$fileName;
        return FileManager1::write($full_path, static::toJSON($array));    
    }

    /**
     * Load array from JSON Path
     * @see Array1::saveAsJSON()
     * @param null $fromFilePath
     * @return bool|mixed
     */
    static function readFromJSON($fromFilePath = null){ 
        if(!file_exists($fromFilePath)) return false;
        return static::fromJSON( FileManager1::read($fromFilePath) );
    }

    /**
     * Duplicate array value as key
     *  e.g [hi, hello, thnks] = [hi=hi, hello=hello, thnks=thnks]
     * @param $valueList
     * @return array
     */
    static function reUseValueAsKey($valueList){
        $newArray = [];
        foreach ($valueList as $key => $value){ $newArray[$value]= $value; }
        return $newArray;
    }


    /**
     * This is a type of arrey that occured in form request array of form control
     * Example
     *      <input type="file" name="images[]">
     *      to get $_FILE['images'] as separate control, because the control name is array, you will need this
     *
     * "name"     =>  array(3)
        [
            0 => string(8) "logo.png"
            1 => string(24) "FB_IMG_1477050973313.jpg"
            2 => string(24) "FB_IMG_1477050973313.jpg"
    ]
        "type"     =>  array(3)
            [
            0 => string(9) "image/png"
            1 => string(10) "image/jpeg"
            2 => string(10) "image/jpeg"
     *
     *
     * @param $linearArray
     * @return array
     */
    static function normalizeLinearRequestList($linearArray){
        $allKeys = array_keys($linearArray);
        $files = [];
        if(is_array($linearArray[$allKeys[0]])) {
            $totalCount = count($linearArray[$allKeys[0]]);
            for($i = 0; $i<$totalCount; $i++){
                foreach ($allKeys as $keyName) $files[$i][$keyName] = $linearArray[$keyName][$i];
            }
        }else return $linearArray;
        return $files;
    }


    /**
     * @param $list
     * @param string $logic
     * @return array
     */
    static function maxOrMinKeyValue($list, $logic = '>'){
        $keyCount = ($logic === '<')? array_values(self::maxOrMinKeyValue($list, '>'))[0]: 0;
        foreach ($list as $value){
            if($logic === '>')  { if($value > $keyCount) $keyCount = $value; }
            else { if($value < $keyCount) $keyCount = $value; }
        }
        $maxKey = array_search($keyCount, $list);
        return [$maxKey=> $list[$maxKey]];
    }

    /**
     * @param $list
     * @param string $login
     * @return int
     */
    static function maxOrMin($list, $login = '>'){
        $keyCount = ($login === '<')? (self::maxOrMin($list, '>')): 0;
        foreach ($list as $key=> $value) {
            if($login === '>')  { if($value > $keyCount) $keyCount = $value; }
            else { if($value < $keyCount) $keyCount = $value; }
        }
        return $keyCount;
    }


    /**
     * @param string $separator
     * @param $arrayList
     * @param bool $recursive
     * @return string
     */
    static function implode($separator = ',', $arrayList, $recursive = true){
        $output = "";
        foreach ($arrayList as $av){
            if (is_array ($av) && $recursive) $output .= self::implode($separator, $av); // Recursive Use of the Array
            else $output .= $separator.$av;
        }
        return $output;
    }


    /**
     * Extract Array From Mark Up
     * @param $xmlObject
     * @return array
     */
    static function fromXMLObject ($xmlObject){
        $initArrayList = array ();
        foreach ( (array) $xmlObject as $index => $node )
            $initArrayList[$index] = ( is_object ( $node ) ) ? self::fromXMLObject ( $node ) : $node;
        return $initArrayList;
    }

    /**
     * Extract Array From Mark Up
     * @param $xml_data
     * @return SimpleXMLElement[]
     */
    static function fromXML($xml_data){
        $xml = simplexml_load_string($xml_data); //return SimpleXMLElement, wic can be passsed to self::fromXMLObject()
        return $xml->xpath('/ROOT');
    }


    /**
     * @param $array array
     * @param string $append
     * @param string $prepend
     * @return array
     *      Surround Array Items with Appended/Prepended Data
     */
    static function wrap($array, $append = '', $prepend = ''){
        return array_map(function($item) use ($append, $prepend){
            return $append.$item.$prepend;
        }, $array);
    }

    /**
     * @param $array array
     * @return string Last Array
     */
    static function getLastItem($array){ return end($array); }

    /**
     * @param $array array
     * @return string Last Array
     */
    static function getFirstItem($array){ return isset($array[0])?$array[0]:null; }

    static function pickOne(array $options){ return $options[array_rand($options)]; }

    /**
     * @param array $key_and_value
     * @param string $keyValueDelimiter
     * @param string $delimiter
     * @param string $keyWrap
     * @param string $valueWrap
     * @return string
     *      merger KeyValue together
     *      E.G self::mergeKeyValue($key_and_value = ['name'=>'samson', 'email'=>'sams@gmail.com'], $keyValueDelimiter = '=', $delimiter = ' , ', $keyWrap = "%s", $valueWrap = "(%s)")
     *          OUTPUT: name=(samson) , email=(sams@gmail.com)
     *
     */
    static function mergeKeyValue($key_and_value = [], $keyValueDelimiter = '=', $delimiter = ' ', $keyWrap = "%s", $valueWrap = "%s"){
        $str = '';
        $index=0;
        foreach($key_and_value as $key=>$value){
            if($index != 0) $str .= $delimiter;
            $str .= sprintf($keyWrap, $key). $keyValueDelimiter. sprintf($valueWrap, $value);
            $index++;
        }
        return $str;
    }


    /**
     * @param array $attributes
     * @param bool $allowNumber prevent ['class'=>'col-3', checked, food] = class='col-3' 0="checked"  1="food"
     * @return string class="col-3" checked value="online"
     */
    static function toHtmlAttribute($attributes = [], $allowNumber = false){
        if (empty($attributes))  return '';
        if (!is_array($attributes))  return $attributes;
        $attributePairs = [];
        foreach ($attributes as $key => $val) {
            if (is_int($key))  $attributePairs[] = $val;
            else {
                $val = htmlspecialchars($val, ENT_QUOTES);
                $attributePairs[] = "{$key}=\"{$val}\"";
            }
        }
        return join(' ', $attributePairs);
    }


    /**
     * @param string $startWith Start With String
     * @param null $andEndWith
     * @param array $arrayToSearch
     * @param array $except
     * @return array
     * @internal param string $endWith End With String
     */
    static function getArraysWith($startWith=null, $andEndWith=null, $arrayToSearch = [], $except = []){
        $newVar = [];

        $isStartWithAvailable = ($startWith && $startWith !== '');
        $isEndWithAvailable = ($andEndWith && $andEndWith !== '');

        foreach ($arrayToSearch as $key => $value) {
            $addKey = [];
            if($isStartWithAvailable && $isEndWithAvailable && !in_array($key, $except)){
                if(String1::startsWith($key, $startWith) && String1::endsWith($key, $andEndWith) ) $addKey[$key] = $value;

            } else if($isStartWithAvailable  && !in_array($key, $except)){
                if(String1::startsWith($key, $startWith)) $addKey[$key] = $value;

            } else if($isEndWithAvailable  && !in_array($key, $except)){
                if(String1::endsWith($key, $andEndWith)) $addKey[$key] = $value;

            } else if(!in_array($key, $except)){
                $addKey[$key] = $value;

            }

            $newVar = array_merge($newVar, $addKey);
        }
        return $newVar;
    }


    /**
     * Filter and Remove Empty Space from Array
     * @param $delimiter
     * @param $string
     * @return array
     */
    static function splitAndFilterArrayItem($delimiter, $string){
        $string = trim($string, $delimiter);
        return  self::filterArrayItem(  explode($delimiter, $string)  );
    }

    /**
     * Filter and Remove Empty Space from Array
     * @param $array
     * @param string $callbackFilterFunction
     * @return array
     */
    static function filterArrayItem($array, $callbackFilterFunction = 'strlen'){
        return  (array_filter(Array1::toArray($array), $callbackFilterFunction));
    }



    /**
     * @param array $array_key_value
     * @param array $exceptKeyList
     * @param string $callbackSanitizeFunction
     * @return array
     *
     *  Filter array Item With A Function That accept $value Parameter
     */
    static function sanitizeArrayItemValue($array_key_value = [], $exceptKeyList = [], $callbackSanitizeFunction='static::getSanitizeValue'){
        $arrBuff = [];
        foreach ($array_key_value as $key=>$value){
            if($exceptKeyList && (count($exceptKeyList) > 0) && in_array($key, $exceptKeyList)) $arrBuff[$key] = ($value);
            else $arrBuff[$key] = $callbackSanitizeFunction($value);
        }
        return $arrBuff;
    }


    /**
     * Filter and Remove Empty Space from Array
     * @param $arrayList
     * @param string $defaultValue
     * @param array $excludeKey
     * @return array
     */
    static function initEmptyValueTo($arrayList, $defaultValue = '', $excludeKey = []){
        $arrayValueList = [];
        foreach ($arrayList as $key=>$value){
            $newData = [];

            if(!in_array($key, $excludeKey)){
                if(String1::is_empty($value)) $newData[$key] = $defaultValue;
                else  $newData[$key] = $value;
                $arrayValueList += $newData;
            }
        }
        return  $arrayValueList;
    }

    /**
     * Remove Un wanted Key From Array
     * @param $arrayList
     * @param array $excludeKey
     * @return array
     */
    static function except($arrayList, $excludeKey = []){
        $arrayList = self::makeArray($arrayList);
        $excludeKey = self::makeArray($excludeKey);
        foreach ($excludeKey as $key){
            if(isset($arrayList[$key])) unset($arrayList[$key]);
        }
        return  $arrayList;
    }


    /**
     * Fill Data into array, usually useful in Table where you don't want to miss a column, and you trynna balance table rows together.
     *
     * @param $array
     * @param $spaceCountToFill
     * @param string $valueToFIll
     */
    static function fillRemainingSpace(&$array, $spaceCountToFill, $valueToFIll = ' '){
        $array = array_merge($array, array_fill(0, ($spaceCountToFill), $valueToFIll));
    }


    static function trim($array = [], $trimCharSet = '( )"\''){
        return array_map( function($item) use ($trimCharSet){ return trim($item, $trimCharSet); }, $array );
    }

    public static function exists($arrayList, $keyToSearch){
        if ($arrayList instanceof ArrayAccess) return $arrayList->offsetExists($keyToSearch);
        return array_key_exists($keyToSearch, $arrayList);
    }

    static function removeKeys($array, $keysToRemoveList = []) {
        foreach ($keysToRemoveList as $key){ if($key) unset($array[$key]); };
        return $array;
    }

    static function replaceKeyName($array, $oldKeyName, $newKeyName){
        $array[$newKeyName] = $array[$oldKeyName]; unset($array[$oldKeyName]); return $array;
    }


    /**
     * Walk through array and replace victim value with callback
     * @param array $keyValueArrayList
     * @param array $searchKey
     * @param callable $callbackForFoundValue
     * @return array
     */
    static function replaceValueIfKeyExist($keyValueArrayList = ['name'=>'sam...'], $searchKey = ['name'], callable $callbackForFoundValue = null) {
        $buff = [];
        $searchKey = array_flip(array_values($searchKey));
        foreach ($keyValueArrayList as $key=> $value){
            if(isset($searchKey[$key])) $buff[$key] = $callbackForFoundValue($value);
            else $buff[$key] = $value;
        }
        return $buff;
    }

    /**
     * @param array $arrayList of Value to replace keyName
     * @param array $oldName_equals_to_newName (Replace $arrayList KeyName with keyValue)
     * @return array
     */
    static function replaceKeyNames($arrayList, $oldName_equals_to_newName = ['oldName'=>'newName']){
        if(!$oldName_equals_to_newName || empty($oldName_equals_to_newName)) return $arrayList;

        $newNames = [];
        $allNewName = array_keys($oldName_equals_to_newName);
        foreach ($arrayList as $key=> $value){
            if(in_array($key, $allNewName)) $newNames[$oldName_equals_to_newName[$key]] = $value;
            else $newNames[$key] = $value;
        }
        return $newNames;
    }


    /**
     * Replace all Array Values with new input value
     * @param $arrayList
     * @param array $oldValue_equals_to_newValues
     * @return array
     */
    static function replaceValues($arrayList, $oldValue_equals_to_newValues = ['one'=>'1']){
        if(!$oldValue_equals_to_newValues || empty($oldValue_equals_to_newValues)) return $arrayList;
        $newValues = [];
        $allNewValues = array_keys($oldValue_equals_to_newValues);
        foreach ($arrayList as $key => $value) {
            if(in_array($value, $allNewValues)) $newValues[$key] = $allNewValues[$value];
            else $newValues[$key] = $value;
        }
        return $newValues;
    }

    /**
     * Replace all Array Key Values that contains the given string
     * @param array $arrayList
     * @param string $search
     * @param string $replace
     * @param string $searchPosition
     * @return array
     */
    static function replaceInKeys($arrayList = [], $search = '', $replace = '', $searchPosition = 'contain'){
        $newValues = [];
        foreach ($arrayList as $key => $value) {
            if($searchPosition === 'start') $newKey = String1::replaceStart($key, $search, $replace);
            else if($searchPosition === 'end') $newKey = String1::replaceEnd($key, $search, $replace);
            else $newKey = String1::replace($key, $search, $replace);
            $newValues[$newKey] = $value;
        }
        return $newValues;
    }

    /**
     * Replace all Array Key Start Values that contains the given string
     * @param array $arrayList
     * @param string $search
     * @param string $replace
     * @return array
     */
    static function replaceKeysStart($arrayList = [], $search = '', $replace = ''){ return self::replaceInKeys($arrayList, $search, $replace, $searchPosition = 'start'); }

    /**
     * Replace all Array Key End Values that contains the given string
     * @param array $arrayList
     * @param string $search
     * @param string $replace
     * @return array
     */
    static function replaceInKeysEnd($arrayList = [], $search = '', $replace = ''){ return self::replaceInKeys($arrayList, $search, $replace, $searchPosition = 'end'); }


    /**
     * Replace all Array Value Values that contains the given string
     * @param array $arrayList
     * @param string $search
     * @param string $replace
     * @param string $searchPosition
     * @return array
     */
    static function replaceInValues($arrayList = [], $search = '', $replace = '', $searchPosition = 'contain'){
        $newValues = [];
        foreach ($arrayList as $key => $value) {
            if($searchPosition === 'start') $newValue = String1::replaceStart($value, $search, $replace);
            else if($searchPosition === 'end') $newValue = String1::replaceEnd($value, $search, $replace);
            else $newValue = String1::replace($value, $search, $replace);
            $newValues[$key] = $newValue;
        }
        return $newValues;
    }

    /**
     * Replace all Array Value Start Values that contains the given string
     * @param array $arrayList
     * @param string $search
     * @param string $replace
     * @return array
     */
    static function replaceValuesStart($arrayList = [], $search = '', $replace = ''){ return self::replaceInValues($arrayList, $search, $replace, $searchPosition = 'start'); }

    /**
     * Replace all Array Value End Values that contains the given string
     * @param array $arrayList
     * @param string $search
     * @param string $replace
     * @return array
     */
    static function replaceValuesEnd($arrayList = [], $search = '', $replace = ''){ return self::replaceInValues($arrayList, $search, $replace, $searchPosition = 'end'); }





    public static function containValue($arrayList, $keyToSearch){
        $valueList = array_values($arrayList);
        return isset($valueList[$keyToSearch]);
    }


    /**
     *
     * Search Array key and Value for a particular list of another array
     *  @See Array1::startsWith(),  @See Array1::endsWith()
     *
     * @param array $arrayList
     * @param array $needleListToSearch
     * @param bool $recursive
     * @param string $searchPosition [ could be 'contain' or 'start' or 'end']
     * @return array
     */
    static function contain($arrayList = [], $needleListToSearch = [], $recursive = false, $searchPosition = 'contain'){
        $exists = [];
        foreach (self::makeArray($arrayList) as $key => $value) {
            foreach (self::makeArray($needleListToSearch) as $needleValue ){
                if($recursive) if (is_array($value))  array_merge($exists, self::makeArray(self::search($value, $needleListToSearch, $recursive)));
                $isStartEnd = (($searchPosition === 'contain') && ((!is_array($key) && String1::contains($needleValue, $key)) || (!is_array($value) && String1::contains($needleValue, $value))));
                $isStart = (($searchPosition === 'start') && ((!is_array($key) && String1::startsWith($key, $needleValue)) || (!is_array($value) && String1::startsWith($value, $needleValue))));
                $isEnd = (($searchPosition === 'end') && ((!is_array($key) && String1::endsWith($key, $needleValue)) || (!is_array($value) && String1::endsWith($value, $needleValue))));

                if( $isStartEnd || $isStart || $isEnd){
                     $exists[$key] = $value;
                     continue;
                }
            }
        }
        return $exists;
    }

    static function startsWith($arrayList = [], $needleListToSearch = [], $recursive = false){ return self::contain($arrayList, $needleListToSearch, $recursive, 'start'); }

    static function endsWith($arrayList = [], $needleListToSearch = [], $recursive = false){ return self::contain($arrayList, $needleListToSearch, $recursive, 'end'); }

    /**
     * Get Last Array
     * @param array $array
     * @return mixed
     */
    static function last($array = []){ $dd = $array; return end($dd); }

    /**
     * Array Pop off last Element
     * @param array $array
     * @return array
     */
    static function removeLast($array = []){ array_pop($array); return $array; }


    /**
     * Array Pop  off first Element
     * @param array $array
     * @return array
     */
    static function removeFirst($array = []){ array_shift($array); return $array; }


    /**
     * @param callable|null $valueCallback
     * @param array $primaryAndCompleteArray
     * @param array $otherArray
     * @return array
     *              return all common field present in $primaryAndCompleteArray and $otherArrayList1, $otherArrayList2...
     *              FOR LARAVEL REQUEST VALIDATE, USE Request2::getAvailableFields();
     */
    static public function getCommonField(Callable $valueCallback = null, $primaryAndCompleteArray = [], ...$otherArray){
        $requestKeyValue = [];
        foreach ($primaryAndCompleteArray as $key=>$value) {
            $isKeyExists = true;
            foreach ($otherArray as $array) {if (!isset($array[$key])) $isKeyExists = false;}
            if($isKeyExists) {$requestKeyValue[$key] = ($valueCallback)? $valueCallback($value): $value;}
        }
        return $requestKeyValue;
    }


    /**
     * Escapse Value with quote
     * @param $arrayList
     * @return string
     */
    static function addSlashes($arrayList){
        if(is_array($arrayList)){
            foreach($arrayList as $n=> $v){
                $b[$n]=self::addSlashes($v);
            }
            return $b;
        }else{
            return addslashes($arrayList);
        }
    }


    /**
     * @param array $array
     * @param int $count
     * @param bool $allowDuplicates
     * @return array
     */
    public static function randomElements(array $array = array('a', 'b', 'c'), $count = 1, $allowDuplicates = false){
        $allKeys = array_keys($array);
        $numKeys = count($allKeys);
        if (!$allowDuplicates && $numKeys < $count) throw new \LengthException(sprintf('Cannot get %d elements, only %d in array', $count, $numKeys));
        $highKey = $numKeys - 1;
        $keys = $elements = array();
        $numElements = 0;
        while ($numElements < $count) {
            $num = mt_rand(0, $highKey);
            if (!$allowDuplicates) {
                if (isset($keys[$num])) continue;
                $keys[$num] = true;
            }
            $elements[] = $array[$allKeys[$num]];
            $numElements++;
        }
        return $elements;
    }
}

class RecursiveArrayObject1 extends \ArrayObject {
    public function __construct($input = null, $flags = self::ARRAY_AS_PROPS, $iterator_class = "ArrayIterator"){
        foreach($input as $k=>$v) $this->__set($k, $v);
        return $this;
    }
    public function __set($name, $value){
        if (is_array($value) || is_object($value))
            $this->offsetSet($name,(new self($value)));
        else
            $this->offsetSet($name, $value);
    }
    public function __get($name){
        if ($this->offsetExists($name))
            return $this->offsetGet($name);
        elseif (array_key_exists($name, $this)) {
            return $this[$name];
        }
        else {
            throw new \InvalidArgumentException(sprintf('$this have not prop `%s`',$name));
        }
    }
    public function __isset($name){
        return array_key_exists($name, $this);
    }
    public function __unset($name){
        unset($this[$name]);
    }
}

class ArrayObject1  extends ArrayObject{

    public function __get($index){ if ($this->offsetExists($index)) return $this->offsetGet($index);  else  return null;}//throw new UnexpectedValueException('Undefined key ' . $index); }

    public function __set($index, $value){ $this->offsetSet($index, $value); return $this;}

    public function __isset($index){return $this->offsetExists($index);}

    public function __unset($index){ return $this->offsetUnset($index); }

    public function __toString() { return serialize($this); }


    public function __construct(...$object_or_array) { foreach ($object_or_array as $arguments){ if (!empty($arguments)) { foreach ($arguments as $property => $argument) { $this->{$property} = $argument; } } } }

    public function addObject(...$object_or_array) { foreach ($object_or_array as $arguments){ if (!empty($arguments)) { foreach ($arguments as $property => $argument) { $this->{$property} = $argument; } } } }
    public function addMethod($methodName, callable $callback) { $this->{$methodName} = $callback; }


    public function __call($method, $arguments) {
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            die("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
}

class exArrayObject1 extends ArrayObject1{}

class Class1{

    /**
     * @param array|object $object_or_array
     * @return mixed
     * <p>
     *     this can be use to merge php class object together,
     *     to make object behave like array and array like object,
     *     and also show all functions in each object.
     *     to add more function
     *         Example
     *             $flexibleObject = Class1::toArrayObject( (new User), (new Picture) );
     *             $flexible->newMethod = function (){
     *                 return 'hello world';
     *             }
     *
     *
     *             echo $flexibleObject->fullName;
     *                         OR
     *             echo $flexibleObject['fullName'];
     *
     *                         OR
     *             Console1::print( $flexibleObject );
     * </p>
     */
    public static function toArrayObject(...$object_or_array){


        // create flexible ArrayObject that allows onFly Method to be added
        $flexibleObject = null;
        for($i=0; $i<count($object_or_array); $i++){
            if($i === 0) $flexibleObject = new exArrayObject1($object_or_array[$i]); // new ArrayObject($object_OR_array, ArrayObject::ARRAY_AS_PROPS)
            else $flexibleObject->addObject($object_or_array[$i]); // merge multiple object
        }

        // Add List Of Existing Methods in '$object_or_array' to Current Object
        foreach ($object_or_array as $object ){
            if(is_object($object)){
                foreach ( get_class_methods($object) as &$method ) { //// get_object_vars($clunker)
                    $flexibleObject->{$method} = function(...$param) use ($object, $method) { return call_user_func_array([($object), $method], $param); };
                }
            }
        }

        return $flexibleObject;
    }


    static function cast($object, $class = 'object', $addMethods = false) {
        if( !class_exists($class) ) $class = __NAMESPACE__ . "\\$class";
        if( !class_exists($class) ) throw new InvalidArgumentException(sprintf('Unknown class: %s.', $class));

        // case with serialization
        $newObject = @unserialize(
            preg_replace(
                '/^O:\d+:"[^"]++"/',
                'O:'.@strlen($class).':"'.$class.'"',
                serialize($object)
            )
        );

        // add methods
        if($addMethods && is_object($object)){
            foreach ( get_class_methods(new $class) as &$method ) {
                $newObject->{$method} = function(...$param) use ($object, $method) { return call_user_func_array([($object), $method], $param); };
            }
        }

        return $newObject;
    }



    static function toObject($array, $className = null, $addMethod = false){ return self::convertArrayToObject($array, $className, $addMethod); }

    static function toArray($object){ return json_decode( json_encode($object) , 1);}

    static function convertObjectToArray($object) {
        if(is_array($object)) return $object;
        $_arr = is_object($object) ? get_object_vars($object) : $object;
        $arr = array();
        foreach ($_arr as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? self::convertObjectToArray($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }


    /**
     * @param $array
     * @param string $className
     * @param bool $addMethod
     * @return bool|mixed|$class
     */
    static function convertArrayToObject($array, $className = null, $addMethod = false) {
        if(String1::startsWith($className, 'class@anonymous')) return $array;
        $value = json_decode(json_encode($array), FALSE);
        return ($className)? self::cast($value, $className, $addMethod): $value;
    }


    static function hashCode($obj){
        return spl_object_hash($obj);
    }

    static function mergeObject(...$object_or_array){
        $className = '';
        $objArray = [];
        for($i=0; $i<count($object_or_array); $i++){
            if($i === 0) $className = get_class($object_or_array[$i]);
            $objArray = array_merge($objArray, (array)$object_or_array[$i]); // merge multiple object
        }
        return self::convertArrayToObject($objArray, $className);
    }


    static function getClassObjectVariables($object){
        return get_object_vars($object);
    }

    // both static and object variables
    static function getClassVariables($object){
        return get_class_vars(get_class($object));
    }

    //It relies on an interesting property: the fact that get_object_vars only returns the non-static variables of an object.
    static function getClassStaticVariables($object){
        //print_r( array_diff(self::getAllClassVariables($object), self::getClassVariables($object)) );
        if(is_string($object)) $object = new $object;
        return array_diff(get_class_vars(get_class($object)), get_object_vars($object));
    }


    /**
     * Get Session Executed Class by Name or by Parent Class with debug_backtrace()
     *
     * @param array $classList
     * @param callable $onFoundCallBack
     * @param bool $searchParentClass
     * @return array
     */
    static function getExecutedClass($classList = [], $searchParentClass = false, callable $onFoundCallBack = null){
        $classPie = [];
        foreach (debug_backtrace() as $calledClassInfo){
            foreach (Array1::makeArray($classList) as $class){
                if(isset($calledClassInfo['class']) && $calledClassInfo['class']){
                    if( $calledClassInfo['class'] ==  $class || ( $searchParentClass && self::isParentClassExistIn($calledClassInfo['class'], $class)) ){
                        if($onFoundCallBack)  $onFoundCallBack($calledClassInfo['class']);
                        $classPie[] = $calledClassInfo['class'];
                    }
                }
            }
        }
        return $classPie;
    }



    /**
     * Find Parent Class
     * @param $class
     * @param $parentClass
     * @return bool
     */
    static function isParentClassExistIn($class, $parentClass){ return in_array($parentClass, class_parents($class)); }

    /**
     * Find Parent Implementation
     * @param null $className
     * @param null $parentInterface
     * @return bool
     */
    static function isInterfaceImplementExistIn($className = null, $parentInterface = null){ return in_array($parentInterface, class_implements($className)); }
}

class Object1 extends Class1{ }



class Function1{
    /**
     * Call a function only once.
     * @param $function
     * @return Closure
     */
    static function runOnce($function){
        return function (...$args) use ($function) {
            static $called = false;
            if ($called) {return ;}
            $called = true;
            return $function(...$args);
        };
    }

    /**
     * Return a new function that composes multiple functions into a single callable.
     * @param mixed ...$functions
     * @return mixed
     */
    static function runMultipleFunctionOnResult(...$functions){
        return array_reduce(
            $functions,
            function ($carry, $function) {
                return function ($x) use ($carry, $function) { return $function($carry($x)); };
            },
            function ($x) { return $x; }
        );
    }

    /**
     * Memoization of a function results in memory.
     *
     * $memoizedAdd = static::runAndCache(
        function ($num) { return $num + 10; }
        );

        var_dump($memoizedAdd(5)); // ['result' => 15, 'cached' => false]
        var_dump($memoizedAdd(6)); // ['result' => 16, 'cached' => false]
        var_dump($memoizedAdd(5)); // ['result' => 15, 'cached' => true]
     * @param $func
     * @return Closure
     */
    static function runAndCache($func){
        return function () use ($func) {
            static $cache = [];
            $args = func_get_args();
            $key = serialize($args);
            $cached = true;

            if (!isset($cache[$key])) {
                $cache[$key] = $func(...$args);
                $cached = false;
            }
            return $cache[$key];
            //return ['result' => $cache[$key], 'cached' => $cached];
        };
    }


    /**
     * Curries a function to take arguments in multiple calls.
     * $curriedAdd = Function1::runAndHold(
            function ($a, $b) {
                return $a + $b;
            }
        );

        $add10 = $curriedAdd(10);
        var_dump($add10(15));  // 25
     * @param $function
     * @return Closure
     */
    static function runAndHold($function){
        $accumulator = function ($arguments) use ($function, &$accumulator) {
            return function (...$args) use ($function, $arguments, $accumulator) {
                $arguments = array_merge($arguments, $args);
                $reflection = new ReflectionFunction($function);
                $totalArguments = $reflection->getNumberOfRequiredParameters();

                if ($totalArguments <= count($arguments)) {
                    return $function(...$arguments);
                }

                return $accumulator($arguments);
            };
        };
        return $accumulator([]);
    }






}



class Converter1{
    /**
     * Email Template Parser Class.
     * @param string $templateHtml_or_filePath HTML template string OR File path to a Email Template file.
     * @param array $param ['userName'=>'Samson Iyanu', 'email'=>'samsoniyau@hotmail.com']
     * @return null|string
     */
    public static function bladeTemplateToHtml($templateHtml_or_filePath, $param = []) {
        $_openingTag = '{{';
        $_closingTag = '}}';
        $_valueList = [];

        try
        {

            if(file_exists($templateHtml_or_filePath)) $_template = file_get_contents($templateHtml_or_filePath);// Template HTML is stored in a File
            else if(is_string($templateHtml_or_filePath)) $_template = $templateHtml_or_filePath; // Template HTML is stored in-line in the $emailTemplate property!
            else throw new Exception('ERROR: Invalid Template.  $template must be a String or else a FilePath');

            // load Parameter
            if(is_array($param))  foreach ($param as $key => $value) $_valueList[$key] = $value;
            else throw new Exception('ERROR: Must be an ARRAY.');

            // output
            $html = $_template;
            foreach ($_valueList as $key => $value) {
                if(isset($value) && $value != '')
                    // Better Regex Required for Better Parse
                    $html = str_replace($_openingTag . $key . $_closingTag, $value, $html);
            }
            return $html;
        } catch(Exception $e) {
            echo $e->getMessage(). ' | FILE: '.$e->getFile(). ' | LINE: '.$e->getLine();
        }
        return null;
    }


}


// print or popup text out
class Console1{
    /**
     *  Output Object | Array | String or any data type in a fancy PRE
     * @param string $text
     * @param bool $print_stopPageAndDie
     * @param string $title
     * @return string
     */
    static function println($text = '', $print_stopPageAndDie = false, $title = ''){
        if($text === '')  die('<br><hr><h3 align="center"> Break - [ '.date(DateManager1::date(DateManager1::$time_as24Hours)).' ] </h3><br></hr>');
        if(is_string($print_stopPageAndDie)) {$title = $print_stopPageAndDie; $print_stopPageAndDie = true; };

        echo '<pre class="console1_println" style="direction: ltr; max-width: 90%; margin: 30px auto;overflow:auto; font-family: Monaco, Consolas, \'Lucida Console\',monospace;font-size: 16px;padding: 20px;
                       border-left:20px solid #2295bc;border-right:20px solid #2295bc; border-radius:20px; height:auto !important; 
                       white-space: pre-wrap;  white-space: -moz-pre-wrap;  *white-space: pre-wrap;  white-space: -o-pre-wrap;  word-wrap: break-word;
                       clear:both;top:0;position: relative;z-index: 9999999999;background:#e4e7e7;color:#2295bc">'.(($title !== '')?"<h2>".$title.'</h2><hr/>': '').print_r($text, true).'</pre>';

        if($print_stopPageAndDie) die(''); return '';
    }
    static function out($text = '', $stopPageAndDie = false, $title = ''){ self::println($text, $stopPageAndDie, $title); }


    static function popup(...$text){
        $textBuffer = '';

        foreach ($text as $t)
            $textBuffer .= $t.'\n';

        echo "<script> alert('$textBuffer'); </script>";
    }


    static function log($data){
        $data = String1::toString($data, ', ');
        echo "<script> console.log('----------------SystemDebug-------------'); console.debug($data); </script>";
    }



    static function popupAny($obj){
        echo "<script> alert('".String1::toArrayTree($obj)."'); </script>";
    }



    static function d($data){
        if(is_null($data)){
            $str = "<i>NULL</i>";
        }elseif($data == ""){
            $str = "<i>Empty</i>";
        }elseif(is_array($data)){
            if(count($data) == 0){
                $str = "<i>Empty array.</i>";
            }else{
                $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
                foreach ($data as $key => $value) {
                    $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . self::d($value) . "</td></tr>";
                }
                $str .= "</table>";
            }
        }elseif(is_resource($data)){
            while($arr = mysqli_fetch_array($data)){
                $data_array[] = $arr;
            }
            $str = self::d($data_array);

        }elseif(is_object($data)){
            $str = self::d(get_object_vars($data));
        }elseif(is_bool($data)){
            $str = "<i>" . ($data ? "True" : "False") . "</i>";
        }else{
            $str = $data;
            $str = preg_replace("/\n/", "<br>\n", $str);
        }
        return $str;
    }

    static function dnl($data){
        echo self::d($data) . "<br>\n";
    }

    static function dd($data){
        self::dnl($data);
        return exit? '': '';
    }

    static function ddt($message = ""){
        echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
    }
}

class Color1{
    private static $ALL_COLOR = null;
    private static $COLOR_OFF_WHITE = ['#a36eb1', '#aa0d0d',  '#af80a4',  '#5be47a',  '#d5cf64',  '#67355a',  '#f30089',  '#ff4535',  '#352aff',  '#c6c89e', '#8900c2', '#2e4848', '#444444', '#406626', '#1a9a67', '#666626'];
    private static $COLOR = array(
        'inverse'=>'#2c3e50',
        'info'=>'#2d7cb5',

        'primary'=>'#337ab7',
        'success'=>'#3c763d',
        'danger'=>'#a94442',
        'error'=>'#a94442',
        'warning'=>'#E6AF5F',
    );

    static function initAllColor(){  return static::$ALL_COLOR = (static::$ALL_COLOR)? static::$ALL_COLOR: array_merge(static::$COLOR, String1::isset_or($_SESSION['website_color_list'], [])); }
    static function set($name = '', $color = ''){    static::$ALL_COLOR[$name] = $color; $_SESSION['website_color_list'][$name] = $color; }
    static function get($name = null){ return $name?  String1::isset_or(static::initAllColor()[$name], ''): Object1::toArrayObject(static::initAllColor()); }
    static function getAll(){ static::$ALL_COLOR; }

    // Fix Color
    static function getDanger(){ return     static::get('danger'); }
    static function getSuccess(){ return    static::get('success'); }
    static function getWarning(){ return    static::get('warning'); }
    static function getInverse(){ return    static::get('inverse'); }
    static function getInfo(){ return       static::get('info'); }
    static function getPrimary(){ return    static::get('primary'); }

    // Random Color
    static function getRandomRBG(){ return "rgb(".rand(1,255).",".rand(1,255).",".rand(1,255).")"; }
    static function getRandomName($nameList = ['danger', 'success', 'warning', 'inverse', 'info', 'primary']){ return Array1::pickOne($nameList); }
    static function getRandomList($list = null){ return Array1::pickOne(static::$COLOR_OFF_WHITE); }
    static function getRandomHex(){ return "#".dechex(rand(1,255)).dechex(rand(1,255)).dechex(rand(1,255)); }
}


/**
 * File System Management Class
 * Class FileManager1
 */
class FileManager1{

    /**
     * @param $uri
     * @return null|string
     */
     static function removeDuplicateSlash($uri){
        return preg_replace('/\/+/', '/', '/' . $uri);
     }

    /**
     * Get All Data in Directory and pass to callback
     * @param $path
     * @param bool $supplyFullPath
     * @param callable|null $callBack
     * @return array
     */
    static function getDirectoryFiles($path, $supplyFullPath = true, callable $callBack = null){
        $all = [];
        foreach ( scandir( $path ) as $file ) {
            $pathName = $supplyFullPath?  $path.DIRECTORY_SEPARATOR.$file:  $file;
            if($callBack) {
                $allRaw = $callBack($pathName);
                if($allRaw) $all[] = $allRaw;
            }
            else $all[] = $pathName;
        }
        return $all;
    }


    /**
     * Get Directory Folders
     * @param string $path_orPaths
     * @param string $prepend
     * @param string $append
     * @return array|string
     */
    static function getDirectoriesFolders($path_orPaths = '.', $prepend = '', $append = ''){
        $pathList = [];
        foreach (Array1::makeArray($path_orPaths) as $path){
            foreach ( scandir( $path ) as $folder ) {
                $fullPath = $prepend.$path.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$append;
                if (is_dir($fullPath)) $pathList[] = $fullPath;
            }
        }
        return $pathList;
    }


    /**
     * Get all File in derectory
     * @param string $pathList
     * @param array $filterExtension
     * @param array $ignoreExtension
     * @param int $fileCount
     * @param bool $recursive
     * @return array An array, item is a file
     */
    static function getDirectoriesFiles($pathList = '.', array $filterExtension = array(), Array $ignoreExtension = array(), $fileCount = -1, $recursive = false){
        $filterExtension = !empty($filterExtension)? array_map('strtolower', $filterExtension): $filterExtension;
        $allFiles = array();
        foreach (Array1::toArray($pathList) as $path){
            $handle = @opendir($path);
            while ($file = @readdir($handle)) {
                $fullPath = rtrim($path, '/\\') . '/' . $file;
                $ext = strtolower(self::getExtension($file));
                if($file != '.' && $file != '..' ){
                    if (is_file($fullPath) && !in_array($ext, $ignoreExtension)) {

                        // filter extension
                        if (!empty($filterExtension)) {
                            if (in_array($ext, $filterExtension)){ $allFiles[] = $fullPath; }
                        } else { $allFiles[] = $fullPath; }

                        // is file list enough
                        if ($fileCount && ($fileCount > 0) && (count($allFiles) >= $fileCount)) break;
                    }else if($recursive && is_dir($fullPath)){
                        $allFiles = array_merge($allFiles, self::getDirectoriesFiles($fullPath, $filterExtension, $ignoreExtension, $fileCount, $recursive));
                    }
                }
            }
            @closedir($handle);
        }
        return $allFiles;
    }




    /**
     * Get an array containing the path of all files in this repository
     * @return array An array, item is a file
     */
    public static function getDirectoryFilesByExtension($path = '', $ext = 'json') {
        $files = [];
        $_files = glob($path.'*.'.$ext);
        foreach($_files as $file) $files[] = str_replace('.'.$ext,'',basename($file));
        return $files;
    }


    /**
     * @param string $filename
     * @return string
     */
    static function getExtension($filename = ''){
        return (strpos($filename, '.'))? Array1::getLastItem(explode(".", $filename)): $filename;
    }


    /**
     * Mime Type
     * @param string $extension
     * @return mixed|string
     */
    static function getMimeType($extension=''){
        $mimes = array('hqx' => 'application/mac-binhex40', 'cpt' => 'application/mac-compactpro', 'doc' => 'application/msword', 'bin' => 'application/macbinary', 'dms' => 'application/octet-stream', 'lha' => 'application/octet-stream', 'lzh' => 'application/octet-stream', 'exe' => 'application/octet-stream', 'class' => 'application/octet-stream', 'psd' => 'application/octet-stream', 'so' => 'application/octet-stream', 'sea' => 'application/octet-stream', 'dll' => 'application/octet-stream', 'oda' => 'application/oda', 'pdf' => 'application/pdf', 'ai' => 'application/postscript', 'eps' => 'application/postscript', 'ps' => 'application/postscript', 'smi' => 'application/smil', 'smil' => 'application/smil', 'mif' => 'application/vnd.mif', 'xls' => 'application/vnd.ms-excel', 'ppt' => 'application/vnd.ms-powerpoint', 'pptx' => 'application/vnd.ms-powerpoint', 'wbxml' => 'application/vnd.wap.wbxml', 'wmlc' => 'application/vnd.wap.wmlc', 'dcr' => 'application/x-director', 'dir' => 'application/x-director', 'dxr' => 'application/x-director', 'dvi' => 'application/x-dvi', 'gtar' => 'application/x-gtar', 'php' => 'application/x-httpd-php', 'php4' => 'application/x-httpd-php', 'php3' => 'application/x-httpd-php', 'phtml' => 'application/x-httpd-php', 'phps' => 'application/x-httpd-php-source', 'js' => 'application/x-javascript', 'swf' => 'application/x-shockwave-flash', 'sit' => 'application/x-stuffit', 'tar' => 'application/x-tar', 'tgz' => 'application/x-tar', 'xhtml' => 'application/xhtml+xml', 'xht' => 'application/xhtml+xml', 'zip' => 'application/zip', 'mid' => 'audio/midi', 'midi' => 'audio/midi', 'mpga' => 'audio/mpeg', 'mp2' => 'audio/mpeg', 'mp3' => 'audio/mpeg', 'aif' => 'audio/x-aiff', 'aiff' => 'audio/x-aiff', 'aifc' => 'audio/x-aiff', 'ram' => 'audio/x-pn-realaudio', 'rm' => 'audio/x-pn-realaudio', 'rpm' => 'audio/x-pn-realaudio-plugin', 'ra' => 'audio/x-realaudio', 'rv' => 'video/vnd.rn-realvideo', 'wav' => 'audio/x-wav', 'bmp' => 'image/bmp', 'gif' => 'image/gif', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'jpe' => 'image/jpeg', 'png' => 'image/png', 'tiff' => 'image/tiff', 'tif' => 'image/tiff', 'css' => 'text/css', 'html' => 'text/html', 'htm' => 'text/html', 'shtml' => 'text/html', 'txt' => 'text/plain', 'text' => 'text/plain', 'log' => 'text/plain', 'rtx' => 'text/richtext', 'rtf' => 'text/rtf', 'xml' => 'text/xml', 'xsl' => 'text/xml', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg', 'mpe' => 'video/mpeg', 'qt' => 'video/quicktime', 'mov' => 'video/quicktime', 'avi' => 'video/x-msvideo', 'movie' => 'video/x-sgi-movie', 'doc' => 'application/msword', 'docx' => 'application/msword', 'word' => 'application/msword', 'xl' => 'application/excel', 'xls' => 'application/excel', 'xlsx' => 'application/excel', 'eml' => 'message/rfc822');
        return (!isset($mimes[strtolower($extension)])) ? 'application/octet-stream' : $mimes[strtolower($extension)];
    }


    /**
     * File Icon
     * @param $filePath
     * @param array|null $returnKeyMap
     * @return string
     */
    static function getFileAndType($filePath, Array $returnKeyMap = null){
        $returnKeyMap = !$returnKeyMap? [
            // media
            'media_picture'=>'fa fa-picture',
            'media_music'=>'fa fa-music',
            'media_video'=>'fa fa-video',
            // code
            'code_css'=>'fa fa-code-o',
            'code_php'=>'fa fa-php',
            'code_aspx'=>'fa fa-file-aspx',
            'code_xml'=>'fa fa-html',
            'code_database'=>'fa fa-database',
            // file
            'file_text'=>'fa fa-file-text-o',
            'file_web'=>'fa fa-code',
            'file_archive'=>'fa fa-file-archive-o',
            'file_excel'=>'fa fa-file-excel-o',
            'file_word'=>'fa fa-file-word',
            'file_powerpoint'=>'fa fa-file-powerpoint',
            'file_font'=>'fa fa-font',
            'file_pdf'=>'fa fa-file-pdf',
            'file_graphics'=>'fa fa-file-image-o',
            'file_application'=>'fa fa-file-o',
            'file_default'=>'fa fa-file-o',
            'picture'=>'fa fa-file-excel',
        ]: $returnKeyMap;

        $ext=strtolower(pathinfo($filePath,PATHINFO_EXTENSION));
        switch($ext){ case"ico":case"gif":case"jpg":case"jpeg":case"jpc":case"jp2":case"jpx":case"xbm":case"wbmp":case"png":case"bmp":case"tif":case"tiff":case"svg":
            $img=$returnKeyMap['media_picture'];break;case"passwd":case"ftpquota":case"sql":case"js":case"json":case"sh":case"config":case"twig":case"tpl":case"md":case"gitignore":case"c":case"cpp":case"cs":case"py":case"map":case"lock":case"dtd":
            $img=$returnKeyMap['file_web'];break;case"txt":case"ini":case"conf":case"log":case"htaccess":
            $img=$returnKeyMap['file_text'];break;case"css":case"less":case"sass":case"scss":
            $img=$returnKeyMap['code_css'];break;case"zip":case"rar":case"gz":case"tar":case"7z":
            $img=$returnKeyMap['file_archive'];break;case"php":case"php4":case"php5":case"phps":case"phtml":
            $img=$returnKeyMap['code_php'];break;case"htm":case"html":case"shtml":case"xhtml":case"xml":case"xsl":case"xslx":
            $img=$returnKeyMap['code_xml'];break;case"wav":case"mp3":case"mp2":case"m4a":case"aac":case"ogg":case"oga":case"wma":case"mka":case"flac":case"ac3":case"tds":case"m3u":case"m3u8":case"pls":case"cue":
            $img=$returnKeyMap['media_music'];break;case"avi":case"mpg":case"mpeg":case"mp4":case"m4v":case"flv":case"f4v":case"ogm":case"ogv":case"mov":case"mkv":case"3gp":case"asf":case"wmv":
            $img=$returnKeyMap['media_video'];break;case"xls":case"xlsx":
            $img=$returnKeyMap['file_excel'];break;case"asp":case"aspx":
            $img=$returnKeyMap['code_aspx'];break;case"sql":case"mda":case"myd":case"dat":case"sql.gz":
            $img=$returnKeyMap['code_database'];break;case"doc":case"docx":
            $img=$returnKeyMap['file_word'];break;case"ppt":case"pptx":
            $img=$returnKeyMap['file_powerpoint'];break;case"ttf":case"ttc":case"otf":case"woff":case"woff2":case"eot":case"fon":
            $img=$returnKeyMap['file_font'];break;case"pdf":
            $img=$returnKeyMap['file_pdf'];break;case"psd":case"ai":case"eps":case"fla":case"swf":
            $img=$returnKeyMap['file_graphics'];break;case"exe":case"msi":
            $img=$returnKeyMap['file_application'];break;
            default: $img=$returnKeyMap['file_default'];
        }
        return $img;
    }

    static function getFileImagePreview($filename, $defaultImage = null){
        $ext = static::getExtension($filename);
        switch ($ext) {
            case"ico":case"gif":case"jpg":case"jpeg":case"jpc":case"jp2":case"jpx":case"xbm":case"wbmp":case"png":case"bmp":case"tif":case"tiff":case"svg": return $filename;
            default: return $defaultImage? $defaultImage: HtmlAsset1::getImageThumb();
        }
    }


    /**
     * Get File Name
     * @param string $filePath
     * @return mixed|string
     */
    static function getName($filePath = ''){
        $filePath = rtrim($filePath, '/\\');
        $filePath = Array1::last(explode('/', $filePath));
        $filePath = Array1::last(explode('\\', $filePath));
        return $filePath;
    }

    /**
     * File Extension
     * @param bool $commonPictureImage
     * @return array
     */
    static function getImageExtension($commonPictureImage = false){ return Picture1::getExtensionList($commonPictureImage); }

    /**
     * File Extension
     * @param bool $common
     * @return array
     */
    static function getDocumentExtension($common = false){
        $commonData = ['txt', 'xls','xlsx', 'doc', 'docx', 'pdf'];
        return $common? $commonData: array_merge(['pptx'],  $commonData);
    }

    /**
     * is File Image
     * @param $filename
     * @param bool $commonPictureImage
     * @return bool
     */
    static function isImageFile($filename, $commonPictureImage = false){
        return in_array(strtolower(self::getExtension($filename)), self::getImageExtension($commonPictureImage))? true: false;
    }

    /**
     * @param $path
     * @return null|string
     */
    static function getFileName($path){  $path = rtrim($path, '/\\');  return preg_replace('/^.+[\\\\\\/]/', '', $path); }

    /**
     * @param $path
     * @return bool|string
     */
    static function getOnlyFileName($path){ $path = rtrim($path, '/\\'); return substr(self::getFileName($path), 0, (strlen(self::getFileName($path)) - strlen(self::getExtension($path)))-1 ); }


    /**
     * @param $path
     * @return bool|string
     */
    static function getOnlyFilePath($path){ return substr($path, 0, (strlen($path) - strlen(self::getOnlyFileName($path))-1 )); }

    /**
     * @param $fileName
     * @return bool
     */
    static function delete($fileName){
        @unlink($fileName);
        @rmdir($fileName);
        return unlink($fileName);
    }

    /**
     * Verify if url exists or use default
     * @param string $url
     * @param string $default
     * @return string
     */
    static function urlPathExistsOr($url = '', $default = ''){
        // path normalizer
        if(String1::startsWith(strtolower($url), 'http')) $path = Url1::urlToPath($url);
        else{
            $path = $url;
            $url = Url1::pathToUrl($url);
        }
        return file_exists($path)? $url: $default;
    }

    /**
     *
     * @param $path
     * @return bool
     */
    static function deleteDirectory($path){ return exec("rm -rf ".escapeshellarg($path)); }

    /**
     * Delete all files in directory recursively
     */
    static function deleteAll($directory, $deleteDirectory = false){
        if (substr($directory,-1) == "/")  $directory = substr($directory,0,-1);
        if (!file_exists($directory) || !is_dir($directory)) return false;
        else if (!is_readable($directory)) return false;
        else {
            $directoryHandle = opendir($directory);
            while ($contents = readdir($directoryHandle)) {
                if($contents != '.' && $contents != '..') {
                    $path = $directory."/".$contents;
                    if(is_dir($path)) { static::deleteAll($path); }
                    else { @unlink($path); }
                }
            }
            closedir($directoryHandle);
            if($deleteDirectory) if(!rmdir($directory)) { return false; }
            return true;
        }
    }

    static function normalizeFilePathSeparator($file, $separator = '/'){
        return preg_replace("#([\\\\/]+)#", $separator, $file);
    }


    /**
     * Return relative path between two sources
     * @param $fromHalfPath
     * @param $toFullPath
     * @param string $separator
     * @return string
     *
     *  $relative = getRelativePath('/var/www/example.com','/var/www/example.com/media/test.jpg');
     *  Function will return /media/test.jpg.
     */
    static function relativePath($fromHalfPath, $toFullPath, $separator = DIRECTORY_SEPARATOR)
    {
        $fromHalfPath = str_replace(array('/', '\\'), $separator, $fromHalfPath);
        $toFullPath = str_replace(array('/', '\\'), $separator, $toFullPath);

        $arFrom = explode($separator, rtrim($fromHalfPath, $separator));
        $arTo = explode($separator, rtrim($toFullPath, $separator));
        while (count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0])) {
            array_shift($arFrom);
            array_shift($arTo);
        }
        return str_pad("", count($arFrom) * 3, '..' . $separator) . implode($separator, $arTo);
    }


    /**
     * @param $source_url
     * @param $destination
     * @param bool $shouldCompressIfCompressible
     * @return bool
     */
    static function upload($source_url, $destination, $shouldCompressIfCompressible = true){ return Picture1::upload($source_url, $destination, $shouldCompressIfCompressible); }


    /**
     * Generate directory structure
     * @param string $basePath , path where all directories will be created in
     * @param array $relativePathList , recursive array in structure of directories
     * @return bool
     */
    static function generateDirectories($basePath = '\\', Array $relativePathList = ['web'=>['js','css']]){
        //If array, unfold it
        foreach($relativePathList as $key => $path) {
            $folderName = is_numeric($key) ? '' : '\\' . $key;
            self::createDirectory($basePath.$folderName.'\\'.$path);
        }
    }


    static function createDirectory($path = '\\'){
        return @mkdir($path, 0777, true);
    }

     /**
     * Writes data to the filesystem.
     * @param  string $path     The absolute file path to write to
     * @param  string $contents The contents of the file to write
     * @return boolean          Returns true if write was successful, false if not.
     */
    public static function write($path, $contents) {
        $fp = fopen($path, 'w+');
        if(!flock($fp, LOCK_EX)) return false; 
        $result = fwrite($fp, $contents);
        flock($fp, LOCK_UN);
        fclose($fp);
        return $result !== false;
    }

    /**
     * read file
     */
    public static function read($path)  {
        if(!file_exists($path))  return false;
        $file = fopen($path, 'r');
        $contents = fread($file, filesize($path));
        fclose($file); 
        return $contents;
    }


    


    static function loadComposerPackage($dir){
        $composer = json_decode(file_get_contents($dir."/composer.json"), 1);
        $loadByPSR = function ($namespaces, $psr4) use ($dir) {
            // Foreach namespace specified in the composer, load the given classes
            foreach ($namespaces as $namespace => $classpaths) {
                if (!is_array($classpaths)) {
                    $classpaths = array($classpaths);
                }
                spl_autoload_register(function ($classname) use ($namespace, $classpaths, $dir, $psr4) {
                    // Check if the namespace matches the class we are looking for
                    if (preg_match("#^".preg_quote($namespace)."#", $classname)) {
                        // Remove the namespace from the file path since it's psr4
                        if ($psr4) {
                            $classname = str_replace($namespace, "", $classname);
                        }
                        $filename = preg_replace("#\\\\#", "/", $classname).".php";
                        foreach ($classpaths as $classpath) {
                            $fullpath = $dir."/".$classpath."/$filename";
                            if (file_exists($fullpath)) {
                                include_once $fullpath;
                            }
                        }
                    }
                });
            }
        };

        (isset($composer['autoload']['psr-4']) &&  $loadByPSR($composer['autoload']['psr-4'], true));
        (isset($composer['autoload']['psr-0']) && $loadByPSR($composer['autoload']['psr-0'], false));
    }


    /**
     * Validates the name of the file to ensure it can be stored in the
     * filesystem.
     *
     * @param string $name The name to validate against
     * @param boolean $safe_filename Allows filename to be converted if fails validation
     * @return bool Returns true if valid. Throws an exception if not.
     */
    public static function validateFileName($name, $convertToSafeFilenameIfFailed = false){
        if (!preg_match('/^[0-9A-Za-z\_\-]{1,63}$/', $name)) {
            if ($convertToSafeFilenameIfFailed) {
                // rename the file
                $name = preg_replace('/[^0-9A-Za-z\_\-]/','', $name);
                // limit the file name size
                $name = substr($name,0,63);
            }
            else  throw new \Exception(sprintf('`%s` is not a valid file name.', $name)); 
        }
        return $name;
    }



    private static function __autoClassRecursiveLoaderExecutor ($class, $dir = null, $initPath = null) {
        if ( is_null( $dir ) )  $dir = $initPath;
        foreach ( scandir( $dir ) as $file ) {
            // directory?
            if ( is_dir( $dir.$file ) && substr( $file, 0, 1 ) !== '.' )  self::__autoClassRecursiveLoaderExecutor( $class, $dir.$file.'/' );
            // php file?
            if ( substr( $file, 0, 2 ) !== '._' && preg_match( "/.php$/i" , $file ) ) {
                // filename matches class?
                if ( str_replace( '.php', '', $file ) == $class || str_replace( '.class.php', '', $file ) == $class )  include $dir . $file;
            }
        }
    }
    static function autoClassRecursiveLoad($initPathList = 'app'){
        //$dff =[];
        foreach (Array1::toArray($initPathList) as $initPath){
            $autoLoad = function ($class, $dir = null) use ($initPath){ FileManager1::__autoClassRecursiveLoaderExecutor($class, $dir, $initPath); };
            spl_autoload_register($autoLoad);
            //$dff[] = $initPath;
        }
        //return $dff;
    }
}


/**
 * Determine the framework using Easktax
 * Class Framework1
 */
class Framework1{

    /**
     * Is Framework easytax
     * @return bool|Config1|mixed
     */
    static function getInfoIfEasyTask(){
        if(function_exists('frameworkInfo()') && (frameworkInfo()['name'] === 'easytax') ) return frameworkInfo();
        return false;
    }

}

class MySql1{

    /**
     * Use instead mysqli_real_escape_string
     * @param $string
     * @param null $DB_CONNECTION
     * @return string
     */
    static function mysqli_real_escape($string, $DB_CONNECTION = null){
        if(!$DB_CONNECTION && Framework1::getInfoIfEasyTask()){
            Db1::open();
            $DB_CONNECTION = Db1::$DB_HANDLER;
        }
        $string = @trim($string);
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return mysqli_real_escape_string($DB_CONNECTION, $string);
    }


    /**
     * Use to reverse mysqli_real_escape_string
     * @param $string
     * @return mixed
     */
    static function mysql_unreal_escape($string) {
        $characters = array('x00', 'n', 'r', '\\', '\'', '"','x1a');
        $o_chars = array("\x00", "\n", "\r", "\\", "'", "\"", "\x1a");
        for ($i = 0; $i < strlen($string); $i++) {
            if (substr($string, $i, 1) == '\\') {
                foreach ($characters as $index => $char) {
                    if ($i <= strlen($string) - strlen($char) && substr($string, $i + 1, strlen($char)) == $char) {
                        $string = substr_replace($string, $o_chars[$index], $i, strlen($char) + 1);
                        break;
                    }
                }
            }
        }
        return $string;
    }

    /**
     * Use to reverse mysqli_real_escape_string
     * @param $string
     * @return string
     */
    static function mysql_unreal_escape_lite($string) {
        return  stripslashes(str_replace('\r\n' , '<br/>', nl2br($string)));
    }

    /**
     * Use to reverse mysqli_real_escape_string
     * @param array $dbRowKeyValueArray
     * @param array $filterValueForKeyList
     * @return array
     */
    static function unFilterValueIfKeyExist($dbRowKeyValueArray = ['name'=>'blablabla'], $filterValueForKeyList = ['name']) {
        return Array1::replaceValueIfKeyExist($dbRowKeyValueArray, $filterValueForKeyList, function($value){
            return static::mysql_unreal_escape($value);
        });
    }



    /**
     * @param array $columnsToSearchFrom
     * @param array $textToSearch
     * @param string $logic
     * @param string $operator
     * @return string
     *      Run Many Where Query Against Columns(s)
     *          E.G
     *              function search($text){
     *                 echo static::whereValuesInColumns($columns = ['`title`', '`body`'], $values = ["%$text%", "$text"], $logic = 'OR', $operator = ' LIKE ')
     *              }
     *          OUTPUT : where title LIKE "%text%" OR title LIKE "text" OR body LIKE "%text%" OR body LIKE "text"
     *
     *  ------------------------------------
     *  Use to SelectMany
     *      $builder = Book::selectMany(false, ' WHERE '.MySql1::toWhereValuesInColumnsQuery(['title', 'body'], $searchBreak, 'OR', ' LIKE ').' ORDER BY updated_at desc', Book::$COMMON_FIELD_LITE);
     *
     */
    static function toWhereValuesInColumnsQuery($columnsToSearchFrom = [], $textToSearch = [], $logic = 'OR', $operator = '='){
        $columnsToSearchFrom = Array1::filterArrayItem($columnsToSearchFrom);
        $textToSearch = Array1::filterArrayItem($textToSearch);
        $whereQuery = '';
        for($m=0; $m< count($columnsToSearchFrom); $m++){
            if($m != 0) $whereQuery .= ' '.$logic.' ';
            for($i=0; $i< count($textToSearch); $i++){
                if($i != 0) $whereQuery .= ' '.$logic.' ';
                $whereQuery .= ' '.$columnsToSearchFrom[$m].' '.$operator."'$textToSearch[$i]'";
            }
        }
        return $whereQuery;
    }





    /**
     * @param int $page
     * @param int $limit
     * @return string
     */
    static function makeLimitQuery($page = 1, $limit = 10){
        $start_from = ($page - 1) * $limit;
        return " LIMIT $start_from, $limit ";
    }


    /**
     * @param string $prefixQuery
     * @param int $total
     * @param int $limit
     * @param string $templateClass
     * @param string $requestPageKeyName
     * @return array of ['query'], ['paginate']
     */
    static function makeLimitQueryAndPagination($prefixQuery = '', $total = 0, $limit = 10, $templateClass = BootstrapPaginationTemplate::class, $requestPageKeyName = 'page'){
        $current_page = String1::isset_or($_REQUEST[$requestPageKeyName], 1);
        $query = $prefixQuery.' '.static::makeLimitQuery($current_page, $limit);
        $total_pages = ceil($total / $limit);
        return Object1::toArrayObject(['query'=>$query, 'paginate'=>Page1::renderPagination($total_pages, $templateClass, $requestPageKeyName) ]);


//        /**
//         * Use Template for Current, Next and Previous
//         * i.e Convert This to Template
//         * $pagLink = "<div class='pagination'>";
//        for ($i=1; $i<=$total_pages; $i++) {
//        $pagLink .= "<a href='index.php?page=".$i."'>".$i."</a>";
//        };
//        echo $pagLink . "</div>";
//         */
//        $pageLink = $templateClass::getContainerOpen();
//        if( ($current_page-1) > 0) $pageLink .= $templateClass::getPreviousItem($templateClass::$previousClass, Url1::getPageFullUrl([$requestPageKeyName=>($current_page-1)]));
//        for ($i=1; $i<=$total_pages; $i++) {
//            if($i === $current_page) {
//                $class = $templateClass::$activeClass.' '.$templateClass::$disableClass;      $link = 'javascript:void(0)';
//            } else {
//                $class = ''; $link = Url1::getPageFullUrl([$requestPageKeyName=>($i)]);
//            }
//            $pageLink .= $templateClass::getActiveItem($class, $link, $i);
//        }
//        if( ($current_page+1) <= $total_pages) $pageLink .= $templateClass::getNextItem($templateClass::$nextClass, Url1::getPageFullUrl([$requestPageKeyName=>($current_page+1)]));
//        $pageLink .= $templateClass::getContainerClose();
//        return Object1::toArrayObject(['query'=>$query, 'paginate'=>$pageLink]);
    }









}

class Form1{

    /**
     * All Form Data
     * @param array $array_key_value
     * @param array $exceptKeyList
     * @param string $sanitizeFunction
     * @return array
     */
    static function sanitizeAllValue($array_key_value = [], $exceptKeyList = [], $sanitizeFunction='static::getSanitizeValue'){
        return Array1::sanitizeArrayItemValue($array_key_value, $exceptKeyList, $sanitizeFunction);
    }

    /**
     * Sanitize Form Data
     * @param $data
     * @return bool|string
     */
    static function getSanitizeValue(&$data){
        if(!isset($data))return false;
        $newData = $data;

        $newData = trim($newData);
        $newData = stripcslashes($newData);
        $newData = htmlentities($newData); // for other language attack like german / arabi...
        $newData = htmlspecialchars($newData);

        return ($newData);
    }

    /**
     * @param string $lookupClassNameOrClassFunction
     * @param string $processMethod
     * @return string
     */
    static function toClassCallableLink($lookupClassNameOrClassFunction = 'className@function(param1, param2)', $processMethod = 'process()'){
        // Trim and Generate Url
        $lookupClassNameOrClassFunction = trim($lookupClassNameOrClassFunction);
        $processMethod = trim($processMethod);
        if(class_exists($lookupClassNameOrClassFunction)) $lookupClassNameOrClassFunction = "$lookupClassNameOrClassFunction@$processMethod";
        return $lookupClassNameOrClassFunction;
    }

    /**
     * @param string $lookupClassNameOrClassFunction
     * @param string $processMethod
     * @return string
     */
    static function callController($lookupClassNameOrClassFunction = 'className@function(param1, param2)', $processMethod = 'process()') { return url('/form/'.self::toClassCallableLink($lookupClassNameOrClassFunction, $processMethod)); }

    /**
     * @param string $lookupClassNameOrClassFunction
     * @param string $processMethod
     * @return string
     */
    static function callApi($lookupClassNameOrClassFunction = 'className::function(param1, param2)', $processMethod = 'process()') { return url('/api/'.self::toClassCallableLink($lookupClassNameOrClassFunction, $processMethod)); }



    // filter out html ( storable in db too)
    static function encodeHTML($data){ return htmlentities($data); }
    static function decodeHTML($data){ return html_entity_decode($data); }


    /**
     * re-use html when store in DataBase
     * @param $data
     * @return string
     */
    static function encodeDatabaseHTML($data){ return htmlspecialchars($data);  }

    /**
     * @param $data
     * @return string
     */
    static function decodeDatabaseHTML($data){ return htmlspecialchars_decode($data); }



    static function getSanitizeNumber($id){
        // XSS protection as we might print this value
        return preg_replace("/[^0-9]+/", "", $id);
    }

    static function getSanitizeAlphaNumeric($string){
        // XSS protection as we might print this value
        return preg_replace("/[^a-zA-Z0-9]+/", "", $string);
    }

    static function getEncryptedToken($password, $addBrowserInformation = false){
        //you can change this to user own salt
        $saltStart = "R%W11302&^H2Jk";
        $saltEnd = "^*&ˆH%RwSaMsOn!-oSi";

        $otherStuff = (($addBrowserInformation)?self::getSanitizeValue($_SERVER['HTTP_USER_AGENT']):"");
        return hash("sha512", $saltStart.$password.$saltEnd.$otherStuff);
    }


    static function urlParam_toArray($GET_LIKE_stringParam = 'name=osi&age=25'){
        $param = array(); parse_str($_REQUEST[$GET_LIKE_stringParam], $param);   //parse_str($GET_stringParam, $param);
        return $param;
    }


    /******************************
     *  BASE 64
     ******************************/
    static function base64url_encode($plainText) {
        $base64 = base64_encode($plainText);
        $base64url = strtr($base64, '+/=', '-_,');
        return $base64url;
    }
    static function base64url_decode($plainText) {
        $base64url = strtr($plainText, '-_,', '+/=');
        $base64 = base64_decode($base64url);
        return $base64;
    }
    // encode/decode (Not Safe)
    static function encrypt_base64($data){ return self::base64url_encode($data); }
    static function decrypt_base64($data){ return self::base64url_decode($data); }





    /******************************
     *  Create Form field
     ******************************/
    static function extractUserName($from_string = '', $randomNumber = true){
        $strIsEmail = explode(' ', $from_string)[0];
        $strIsEmail = explode('@', $strIsEmail)[0];
        return self::getSanitizeAlphaNumeric($strIsEmail.($randomNumber?Number1::getRandomNumber(2):''));
    }

    static function generatePassword($length = 16){
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }
        return $string;
    }
}

class DateManager1{
    static $date_asNumber = 'd-m-Y';
    static $date_asText = 'd D M Y';
    static $dateInverse_asNumber = 'Y-m-d';
    static $dateInverse_asText = 'Y-M-D';

    static $time_asAmPm = 'g:i a';
    static $time_as24Hours = 'h:i:s';

    static $dateTime_asNumber = 'd-m-Y h:i:s';
    static $dateTimeInverse_asNumber = 'Y-m-d h:i:s';
    static $database_timeStamp = 'Y-m-d h:i:s';
    static $dateTime_asText = 'l jS F Y,  g:i a';


    /**
     * @return \Carbon\Carbon|string
     */
    static function carbon(){ return \Carbon\Carbon::class; }
    /**
     * @param $date
     * @return \Carbon\Carbon
     */
    static function carbonParse($date){  return \Carbon\Carbon::parse($date); }
    /**
     * @param $date
     * @return string
     */
    static function diffForHumans($date){return \Carbon\Carbon::parse($date)->diffForHumans(); }


    /**
     * @param string $format
     * @param null $timeStamp
     * @param bool $timeStampStrictMode
     * @return false|int|string
     */
    static function date($format = 'd-m-Y h:i:s', $timeStamp = null, $timeStampStrictMode = true){
        if($timeStamp && $timeStampStrictMode && $timeStamp <= 0) return 0;
        return date($format, $timeStamp);
    }

    static function convert24HoursTime_toAmPm($time = ''){ return date("g:i A", strtotime($time)); }
    static function convertAmPmTime_to24Hours($time = ''){ return date("G:i", strtotime($time)); }

    static function now($pretty = false){ return $pretty? self::prettyDateTime(self::now(false)): date(self::$database_timeStamp); }
    static function nowDate($pretty = false){ return $pretty? date(self::$dateInverse_asText): date(self::$dateInverse_asNumber); }
    static function nowTime($pretty = false){ return $pretty? date(self::$time_asAmPm): date(self::$time_as24Hours); }


    static function prettyDateTime($date = null) {
        $date = $date? $date: self::now();
        $x = explode('-', $date);
        $a = $x[0]; $m = $x[1]; $c = $x[2];
        if(strlen($c)>2) {
            $y = $c; $d = $a;
        }
        else if(strlen($a)>2) {
            $y = $a; $d = $c;
        }
        else return $date;
        $mon = "";
        switch($m) {
            case '01': $mon = "Jan"; break;
            case '02': $mon = "Feb"; break;
            case '03': $mon = "Mar"; break;
            case '04': $mon = "Apr"; break;
            case '05': $mon = "May"; break;
            case '06': $mon = "Jun"; break;
            case '07': $mon = "Jul"; break;
            case '08': $mon = "Aug"; break;
            case '09': $mon = "Sep"; break;
            case '10': $mon = "Oct"; break;
            case '11': $mon = "Nov"; break;
            case '12': $mon = "Dec"; break;
        }
        return "$d $mon, $y";
    }

    static function getWeekDayName($date = null) {
        $date = $date? $date: self::nowDate(false);
        $arr = explode('-', $date);
        $d = $arr[2]; $m = $arr[1]; $y = $arr[0];
        $tot = $feb = $sum = 0;
        if($y%4==0) {
            $tot = 366;
            $feb = 29;
        }
        else {
            $tot = 365;
            $feb = 28;
        }

        $mon = array(31, $feb, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        for($i=0; $i<$m-1; $i++) {
            $sum += $mon[$i];
        }
        $dd = $d - 1;
        $sum += $dd;
        if($y>1) $dy = $y - 1;
        $ly = $dy/4;
        $nly = $dy - $ly;
        $ly *= 366;
        $nly *= 365;
        $sum += $ly + $nly;
        $res = $sum%7;

        switch($res) {
            case 0: return "Sunday";
            case 1: return "Monday";
            case 2: return "Tuesday";
            case 3: return "Wednesday";
            case 4: return "Thursday";
            case 5: return "Friday";
            case 6: return "Saturday";
        }
        return '';
    }

    private $time = null;
    private $timeCompare = null;


    /**
     *
     *
     *
     *
            $diff  = new DateManager1( '2018-05-31 22:01:14' ); // OR pass in strtotime('2018-05-31 22:01:14')
            echo $diff->isTimeElapsed()? 'Time Up': $diff->getRemainingTime_asText();
     *
     *
     *
     *
     * DateManager1 constructor.
     * @param string $dataBaseTimeStamp
     * @param null $compareDate_defaultIsNow @default is Now()
     * @param string $dateFormat
     *
     */
    function __construct($dataBaseTimeStamp = '1988-08-10', $compareDate_defaultIsNow = null, $dateFormat = "U = Y-m-d H:i:s"){
        try{
            // is TimeStamp or Use as String
            $this->time = new DateTime();
            if($dataBaseTimeStamp) $this->time = self::normalizeDateOrTimestamp_to_DateTime($dataBaseTimeStamp, $dateFormat);

            // compare
            $this->timeCompare = new DateTime();
            if($compareDate_defaultIsNow) $this->timeCompare = self::normalizeDateOrTimestamp_to_DateTime($compareDate_defaultIsNow, $dateFormat);
        }catch(Exception $ex){
            throw new Exception('Bad Date Format : '. $ex->getMessage());
        }
    }

    /**
     * Know if Time is Up
     *  $dataBaseTimeStamp - $compareDate_defaultIsNow
     * @return bool
     */
    function isTimeElapsed(){ if (!$this->time || !$this->timeCompare  || (($this->timeCompare->getTimestamp() - $this->time->getTimestamp()) <= 0)) return false; else return true; }

    /**
     * @param string $time
     * @param string $dateFormat
     * @return DateTime|string
     */
    static function normalizeDateOrTimestamp_to_DateTime($time = '2007-02-14 20:25:25', $dateFormat = "U = Y-m-d H:i:s"){
        $data = new DateTime();
        if(is_numeric($time)) $data->setTimestamp($time);
        else{
            $data = new DateTime($time);
            $data->format($dateFormat);
        }
        return $data;
    }


    /**
     * echo getRemainingTime() //'Your age is %Y years and %d days' // Your age is 28 years and 19 days
     * @return DateInterval|false|int
     */
    function getRemainingTime_asDateInterval(){
        if($this->isTimeElapsed()) return null;
        return date_diff( $this->time,  $this->timeCompare );
    }

    function getTotalDays(){ if($this->isTimeElapsed()) return 0; return date_diff( $this->time,  $this->timeCompare )->days; }

    function getTotalHours(){ if($this->isTimeElapsed()) return 0; return ($this->getTotalDays() > 0) ? ($this->getRemainingTime_asDateInterval()->h + ($this->getTotalDays() * 24)): $this->getRemainingTime_asDateInterval()->h; }


    /**
     * echo getRemainingTime_asText() // Output: The difference is 28 years, 5 months, 19 days, 20 hours, 34 minutes, 36 seconds
     * @param string $defaultTimeElapseText
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    function getRemainingTime_asText($defaultTimeElapseText = 'Time Up ##:##:##', $prefix = ' ', $suffix = ', '){
        if($this->isTimeElapsed()) return $defaultTimeElapseText;
        $diff = $this->diff();
        $time = String1::ifNotEmpty($diff->y,  " $prefix".$diff->y." ".String1::pluralize_if($diff->y, 'year', 'years' ).$suffix       );
        $time .= String1::ifNotEmpty($diff->m, " $prefix".$diff->m." ".String1::pluralize_if($diff->m, 'month', 'months' ).$suffix    );
        $time .= String1::ifNotEmpty($diff->d, " $prefix".$diff->d." ".String1::pluralize_if($diff->d, 'day', 'days' ).$suffix       );
        $time .= String1::ifNotEmpty($diff->h, " $prefix".$diff->h." ".String1::pluralize_if($diff->h, 'hour', 'hours' ).$suffix      );
        $time .= String1::ifNotEmpty($diff->i, " $prefix".$diff->i." ".String1::pluralize_if($diff->i, 'minute', 'minutes' ).' '   );
        return trim($time, ', ');
    }

    function diff(){ return date_diff( $this->time,  $this->timeCompare); }

    /**
     * echo getRemainingTime_asText() // Output: The difference is 28 years, 5 months, 19 days, 20 hours, 34 minutes, 36 seconds
     * @return string
     */
    function getRemainingTime_asTimeStamp(){
        if($this->isTimeElapsed()) return 0;
        $remDiff = $this->time->diff( $this->timeCompare);
        return $remDiff->format('%a');
        //return strtotime($this->getRemainingTime_asText('', '+', ' '));
    }












    /************************************************************************************************************************************************************************************/
    /*
     *
     *      Static
     *
            $from = (time() + (5 * 60 * 60));
            $fix = (time() + (3 * 60 * 60));
            echo DateManager1::getRemainingTime($from, $fix);
     *
     */
    /************************************************************************************************************************************************************************************/







    /************************************************************************************************************************************************************************************
     *
     *  Check if time elapse, i.e ($fromTime set in DataBase of fix somewhere) - (current time) > futureTimePassingIn as Hours, Days, Weeks
     *  Note That
     *        strtotime('+2 hour')
     *          is the same as time() + (2 * 60 * 60)
     *
     *        strtotime('+2 days') thesame as time() + (2 * 3600)
     *
     * @param int $dbFixTime
     * @param int $minuteAfter
     * @param int $hoursAfter
     * @param int $daysAfter
     * @param int $weeksAfter
     * @return bool
     *
     *      echo( strtotime("now") . "<br>");
     *      echo( strtotime("now") . "<br>");
     *      echo( strtotime("3 October 2005") . "<br>");
     *      echo( strtotime("+5 hours") . "<br>");
     *      echo( strtotime("+1 week") . "<br>");
     *      echo( strtotime("+1 week 3 days 7 hours 5 seconds") . "<br>");
     *      echo( strtotime("next Monday") . "<br>");
     *      echo( strtotime("last Sunday"));
     */
    static function isTimeElapse($dbFixTime = 0, $minuteAfter = 0, $hoursAfter = 0, $daysAfter = 0, $weeksAfter = 0) {
        return ($dbFixTime) < strtotime(self::dateTimeNormalizer( $minuteAfter, $hoursAfter, $daysAfter, $weeksAfter));
    }

    /**
     *  If $dbFixTime less that $compareFutureTime already
     *
     * @param int $dbFixTime
     * @param $compareFutureTime
     * @return bool
     */
    static function isElapse($dbFixTime = 0, $compareFutureTime) { return ($dbFixTime < $compareFutureTime); }

    static function getDaysFrom($dbTimeStamp, $nowTimeStamp = null) {
        $str = (($nowTimeStamp)? $nowTimeStamp: strtotime(date("M d Y "))) - ($dbTimeStamp);
        return floor($str/3600/24);
    }

    /**
     *  Get Remaining Time after Subtracting $dbFixTime. Alternative to @see DateManager1::removeDateTime()
     *
     * @param int $dbFixTime
     * @param int $minuteAfter
     * @param int $hoursAfter
     * @param int $daysAfter
     * @param int $weeksAfter
     * @return int
     */
    static function getRemainingTime($dbFixTime = 0, $minuteAfter = 0, $hoursAfter = 0, $daysAfter = 0, $weeksAfter = 0) {
        $time = ($dbFixTime - strtotime( self::dateTimeNormalizer($minuteAfter, $hoursAfter, $daysAfter, $weeksAfter) ));
        return ($time < 0? 0: $time);
    }

    /**
     *
     *  strtotime() Normaliser.
     *  return some format like +2 months +1 week +3 days + 2 hours + 0 minute
     *
     * @param string $symbol, + or -
     * @param int $minute
     * @param int $hoursAfter
     * @param int $daysAfter
     * @param int $weeksAfter
     * @param int $month
     * @return string
     */
    static function dateTimeNormalizer($symbol = '+', $minute = 0, $hoursAfter = 0, $daysAfter = 0, $weeksAfter = 0, $month = 0){
        $pie = "{$symbol}{$month} ".String1::pluralize_if($month, 'month', 'months')." ";
        $pie .= "{$symbol}{$weeksAfter} ".String1::pluralize_if($weeksAfter, 'week', 'weeks')." ";
        $pie .= "{$symbol}{$daysAfter} ".String1::pluralize_if($daysAfter, 'day', 'days')." ";
        $pie .= "{$symbol}{$hoursAfter} ".String1::pluralize_if($hoursAfter, 'hour', 'hours')." ";
        $pie .= "{$symbol}{$minute} ".String1::pluralize_if($minute, 'minute', 'minutes');
        return $pie;
    }


    /**
     * Add Some Minute, Hours... to  $initTime Date
     *
     * @param int $minute
     * @param int $hours
     * @param int $days
     * @param int $weeks
     * @return int
     */
    static function addDateTime_asDatabaseTimeStamp($minute = 0, $hours = 0, $days = 0, $weeks = 0){
        return date(self::$dateTimeInverse_asNumber, \DateManager1::addDateTime(null, $minute, $hours, $days, $weeks));
    }

    /**
     * Add Some Minute, Hours... to  $initTime Date
     *
     * @param int $minute
     * @param int $hours
     * @param int $days
     * @param int $weeks
     * @return int
     */
    static function removeDateTime_asDatabaseTimeStamp($minute = 0, $hours = 0, $days = 0, $weeks = 0){
        return date(self::$dateTimeInverse_asNumber, \DateManager1::removeDateTime(null, $minute, $hours, $days, $weeks));
    }

    /**
     * Add Some Minute, Hours... to  $initTime Date
     *
     * @param null|int $initTime @default time()
     * @param int $minute
     * @param int $hours
     * @param int $days
     * @param int $weeks
     * @return int
     */
    static function addDateTime($initTime = null, $minute = 0, $hours = 0, $days = 0, $weeks = 0){
        $initTime = $initTime?$initTime:time();
        $time = strtotime(self::dateTimeNormalizer('+', $minute, $hours, $days, $weeks), $initTime);
        return $time;
    }


    /**
     * Remove Some Minute, Hours... from  $initTime Date
     *
     * @param null|int $initTime @default time()
     * @param int $minute
     * @param int $hours
     * @param int $days
     * @param int $weeks
     * @return int
     */
    static function removeDateTime($initTime = null, $minute = 0, $hours = 0, $days = 0, $weeks = 0){
        $initTime = $initTime?$initTime:time();
        $time = strtotime(self::dateTimeNormalizer('-', $minute, $hours, $days, $weeks), $initTime);
        return $time;
    }
}
class Date1 extends DateManager1{}


/**
 * Managa HEadwe
 * Class Header1
 */
class Header1{
    public static function downloadFile($filePath){
        // 301 moved permanently (redirect):
        header('Content-Disposition: attachment; filename=' . urlencode($filePath));
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Description: File Transfer');
        header('Content-Length: ' . filesize($filePath));
        echo file_get_contents($filePath);
    }

    public static function pdf($url){
        header('Content-Type: application/pdf');
        echo file_get_contents($url);
    }


    public static function redirectPermanent($url){
        //302 (redirect):
        header("Location: $url");
        die('waiting for redirection... do it manually if it persist');
    }



    public static function error404(){
        header('HTTP/1.1 404 Not Found');
    }



    public static function serviceNotAvailable(){
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: 60');
    }

    public static function css(){ header('Content-Type: text/css');}

    public static function javascript(){ header('Content-Type: application/javascript'); }
    public static function jpeg(){ header('Content-Type: image/jpeg'); }
    public static function png(){ header('Content-Type: image/png'); }
    public static function bitmap(){ header('Content-Type: image/bmp'); }

    public static function noCache(){
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-view_cache, must-revalidate');
        header('Cache-Control: pre-check=0, post-check=0, max-age=0');
        header ('Pragma: no-view_cache');
    }
    public static function authenticate($userName, $password, callable $callback = null){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="The Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Authenticate Canceled...';
            die();
        } else {
            //always escape your data//
            if($_SERVER['PHP_AUTH_USER']==$userName && $_SERVER['PHP_AUTH_PW']==$password){
                if($callback) $callback();
            }
        }

    }
}

class Url1{


    /**
     * Ping Website, Remove Http://...
     * @param string $host
     * @param int $port
     * @param int $timeout
     * @return bool
     */
    static function pingWithPort($host = 'www.google.com',$port=80,$timeout=6){ return !!(fsockopen($host, $port, $errno, $errstr, $timeout));}

    /**
     * Ping website
     * @param $host
     * @return bool
     */
    static function pingExec($host){
        exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $value);
        return ($value === 0);
    }

    /**
     * Check if website available
     * @param string $host
     * @param bool $returnPageContent
     * @return bool|mixed
     */
    static function ping($host = 'www.google.com', $returnPageContent = false){
        $url = $host;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode>=200 && $httpcode<300) return ($returnPageContent)? $data: true;
        else return false;
    }

    /**
     * Create link to another directory
     * @param $fromDirectory
     * @param $toDirectory
     * @return string
     * @throws Exception
     */
    static function createSymLinks($fromDirectory, $toDirectory){ 
        if(exec("ln -s '$fromDirectory'   '$toDirectory'   ") && !is_link($toDirectory)) throw new Exception(Console1::println("Error Creating createSymLinks from ['$fromDirectory'] to  ['$toDirectory'], Please create it manually").'--- Creating createSymLinks Error --- ', 1);
        return '';
    }

    /**
     * @param null $to
     * @param string $subject
     * @param string $body
     * @param null $from
     * @return bool|ResultStatus1
     */
    static function sendMail($to = null, $subject = '', $body = '', $from = null){
        $headers= '';
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1\r\n";
        $headers .= "From:$from\r\n";
        try{
            if(mail($to, $subject, $body, $headers)) return true;
            return ResultStatus1::falseMessage('Unknown Error Occured');
        }catch (Exception $e){
            return ResultStatus1::falseMessage($e->getMessage());
        }
    }

   

    /**
     * @param null $ip
     * @param bool $deep_detect
     * @return string|null
     */
    static function getIPAddress($ip = null, $deep_detect = TRUE){
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        } else $ip = $_SERVER["REMOTE_ADDR"];
        return $ip;
    }


    /**
     * Return Array  of ...   "ip", "country_code", "country_name", "region_code", "region_name", "city",  "zipcode", "latitude", "longitude",  "metro_code", "areacode",
     * @param null $ip
     * @param string $siteInfo
     * @return bool|string
     */
    static function getIPAddressInformation($ip = null, $siteInfo = 'http://freegeoip.net/json/'){
        return file_get_contents($siteInfo.(($ip)? $ip: $_SERVER['REMOTE_ADDR']) );
    }

    static function getEasyTaxCoreAssetsPath(){ return Page1::getEasyTaxCoreAssetsPath(); }

    static function existInUrl($likelyUrl, $fullCurrentPageUrl = null){
        $fullCurrentPageUrl = $fullCurrentPageUrl? $fullCurrentPageUrl: self::getPageFullUrl();
        if($likelyUrl == '/' || $likelyUrl == 'home' || $likelyUrl == 'index' || (trim($likelyUrl, '/') == trim(Url1::getPageFullUrl(), '/'))  ) if ((trim(Url1::getPageFullUrl(), '/') == trim( path_main_url(), '/')) || String1::endsWith(trim(Url1::getPageFullUrl(), '/'), 'index.php')) return true;
        if(empty($likelyUrl) || empty($fullCurrentPageUrl)) return false;
        return String1::contains(RegEx1::getSanitizeAlphaNumeric(urldecode(urldecode($likelyUrl))), RegEx1::getSanitizeAlphaNumeric(urldecode( $fullCurrentPageUrl? $fullCurrentPageUrl: self::getPageFullUrl() )));
    }

    static function ifExistInUrl($link = '/', $returnValue = 'active', $elseReturnValue = ''){
        return self::existInUrl($link)? $returnValue: $elseReturnValue;
    }

    static function ifUrlEquals($compareFullUrl = 'http://l...', $returnValue = 'active', $elseReturnValue = ''){
        return RegEx1::getSanitizeAlphaNumeric(urldecode(urldecode($compareFullUrl))) == RegEx1::getSanitizeAlphaNumeric(urldecode(urldecode(Url1::getPageFullUrl())))? $returnValue: $elseReturnValue;
    }

    static function buildParameter($param = [], $url = null) {
        if(is_string($param)) {$param = [$param=>$url]; $url = null;}
        $urlArray = array_merge(self::convertUrlParamToArray($url), $param);
        return (self::getPageFullUrl_noGetParameter().'?'.http_build_query($urlArray));
    }

    static function isUrlExist($url){
        $fp = @fopen($url, "r");
        if ($fp === false) return false;
        fclose($fp);
        return true;
    }

    static function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    static function relativePathToUrl($path, $fullDirectoryPath = __DIR__){
        return self::pathToUrl($fullDirectoryPath).DIRECTORY_SEPARATOR.$path;
    }

    static function normalizePath($path){
        $parts = array();// Array to build a new path from the good parts
        $path = str_replace('\\', '/', $path);// Replace backslashes with forwardslashes
        $path = preg_replace('/\/+/', '/', $path);// Combine multiple slashes into a single slash
        $segments = explode('/', $path);// Collect path segments
        $test = '';// Initialize testing variable
        foreach($segments as $segment)
        {
            if($segment != '.')
            {
                $test = array_pop($parts);
                if(is_null($test))
                    $parts[] = $segment;
                else if($segment == '..')
                {
                    if($test == '..')
                        $parts[] = $test;

                    if($test == '..' || $test == '')
                        $parts[] = $segment;
                }
                else
                {
                    $parts[] = $test;
                    $parts[] = $segment;
                }
            }
        }
        return implode('/', $parts);
    }


    static function pathToUrl($path, $redundantPath = null){

        $path = static::normalizePath($path);
        $fileSystemRelativePath = String1::replace($path, $redundantPath? $redundantPath: $_SERVER['DOCUMENT_ROOT'], '' );
        //$fileSystemRelativePath = '/'.FileManager1::relativePath($_SERVER['DOCUMENT_ROOT'], $path);
        return Url1::prependHttp($_SERVER['HTTP_HOST']).$fileSystemRelativePath;
    }

    static function urlToPath($url){
        // convert
        $urlRelativePath1 = String1::replace($url,   Url1::prependHttp($_SERVER['HTTP_HOST']),   '' );
        $urlRelativePath2 = String1::replace($url,   Url1::getSiteMainAddress().str_replace('index.php', '', $_SERVER['PHP_SELF']),   '' );
        $url = $_SERVER['DOCUMENT_ROOT'];

        // return
        if(self::isUrlExist($url.$urlRelativePath1))  return(   $url.$urlRelativePath1 ) ;
        else    return (   $url.$urlRelativePath2);
    }

    static function include_item($url) { //DOMXPath
        $fullPath = self::getRootDirectoryPath()."/".$url;      // this will assign relative path to file, so all link inside can be relative too
        include("$fullPath");
    }

    static function getRootDirectoryPath(){
        //echo getcwd();
        //echo realpath('./');
        //echo realpath(dirname($_SERVER['PHP_SELF']));
        return  dirname($_SERVER['SCRIPT_FILENAME']); // remove 1-PHPClass
    }

    /** is not current url, Which suppose to be in $_GET
     * @param null $url
     * @return array
     */
    static function convertUrlParamToArray($url = null){
        if(!$url) return $_GET;
        $split = explode('?', urldecode($url));
        $existParam  = [];
        if(isset($split[1])) parse_str($split[1], $existParam);
        return $existParam;
        //        $existParam  = []; if($url) parse_str(explode('?', urldecode($url))[1], $existParam);
        //        return $url? $existParam : $_GET;
    }

    static function prependHttp($url){
        $http = isset($_SERVER['HTTPS']) ? "https://" : "http://";
        return (String1::contains('http', strtolower($url))? $url: $http.$url);
    }


    static function isHttps(){
       return isset($_SERVER['HTTPS']) ? true : false;
    }



    static function getSiteMainAddress_fromRoute(){ return str_replace('index.php', '', $_SERVER['PHP_SELF']);  }

    static function getSiteMainAddress($server = null, $use_forwarded_host = false ){
        $server = ($server)?$server:$_SERVER;
        $ssl = (!empty($server['HTTPS']) && $server['HTTPS'] == 'on');
        $sp = strtolower($server['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $server['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = ($use_forwarded_host && isset($server['HTTP_X_FORWARDED_HOST'])) ? $server['HTTP_X_FORWARDED_HOST'] : (isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : null);
        $host = isset($host) ? $host : $server['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    static function getSiteMainAddress_from($url){
        //remove http://
        $urlRaw = (String1::contains("//", $url))?explode("//", $url):"";
        $url = (is_array($urlRaw))?$urlRaw[1]:$url;

        //remove / or ?
        $data = (String1::contains("/", $url))?explode("/", $url): explode("?", $url);
        return (is_array($urlRaw)?$urlRaw[0]."//":"").$data[0];
    }

    static function getPageFullUrl($replaceParameter = [], $removeParameterKey =[], $server = null, $use_forwarded_host = false ){
        if(!empty($replaceParameter)) return self::replaceParameterAndGetUrl($replaceParameter, $removeParameterKey); //Url1::buildParameter(array_merge(Url1::convertUrlParamToArray(), $replaceParameter), self::getPageFullUrl_noGetParameter());
        else {
            $server = ($server)?$server:$_SERVER;
            return self::getSiteMainAddress($server, $use_forwarded_host) . $server['REQUEST_URI'];
        }
    }


    static function getPageFullUrl_noGetParameter($server = null, $use_forwarded_host = false){ return explode('?', self::getPageFullUrl($server, $use_forwarded_host))[0]; }
    static function getCurrentUrl($withParameter = false){ return $withParameter?  static::getPageFullUrl() : static::getPageFullUrl_noGetParameter(); }

    static function replaceParameterAndGetUrl($replaceParameter = [], $removeParameterKey =[], $url = null){
        if(empty($replaceParameter) && $removeParameterKey) return self::getPageFullUrl();
        $allParam = array_merge(Url1::convertUrlParamToArray($url), $replaceParameter);
        foreach ($removeParameterKey as $param) unset($allParam[$param]);
        return Url1::buildParameter($allParam, self::getPageFullUrl_noGetParameter());
    }

    static function getParameter($asArray = false){
        if($asArray) return $_GET;
        $par =  explode('?', urldecode(Url1::getPageFullUrl()));
        return isset($par[1])? $par[1]: '';
    }

    static function getPageName($url = null){
        $url = ($url)? $url: self::getPageFullUrl();
        $norLink = explode('/', explode('?', $url)[0]);
        return end($norLink);
    }

    static function getSiteName($url = null){
        $url = ($url)? $url: self::getSiteMainAddress();

        $url = self::getSiteMainAddress_from($url);
        $url = str_replace('//www.', '//', strtolower($url));

        //remove http://
        $urlRaw = (String1::contains("//", $url))?explode("//", $url):"";
        $url = (is_array($urlRaw))?$urlRaw[1]:$url;

        $dataRaw = (String1::contains(".", $url))?explode(".", $url):"";
        $data = (is_array($dataRaw))?$dataRaw[0]:$url;

        return $data;
    }



    static function backUrl(){
        $url = String1::isset_or($_SERVER['HTTP_REFERER'],   (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        return $url;  // return htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
    }

    static function redirect($redirectUrl = '/', $status = [], $param = []){
        if(Url1::getPageFullUrl() == $redirectUrl) return false;


        if($redirectUrl === '' || $redirectUrl === null) $redirectUrl = self::backUrl();
        if(!empty($param)) Page1::saveSharedVariable($param);
        if(!empty($status)) Session1::setStatusFrom($status);

        //ob_start(); // add to top of the page
        // header('refresh:5;url=redirectpage.php ')
        if (!headers_sent()) { header('Location: '.$redirectUrl); exit; }

        if (true){
            echo '<script type="text/javascript">';
            echo '  console.log("Redirecting to : '.$redirectUrl.'");';
            echo '  window.location.href="'.$redirectUrl.'";';
            echo '</script>';

            echo '<noscript>';
            echo '  <meta http-equiv="refresh" content="0;url='.$redirectUrl.'" />';
            echo '</noscript>'; exit;
        }

        //ob_end_flush();
        return '';
    }


    /**
     * Example
     * \Url1::redirectIf(\Session1::get('last_page'), 'Welcome Back', [\Session1::exists('last_page')]);
     * @param null $redirectUrl
     * @param array $message
     * @param array $trueConditionList
     * @param array $additionalData
     * @param callable|string $elseCallback
     * @return null
     */
    static function redirectIf($redirectUrl = null, $message = [], $trueConditionList = [true], $additionalData = [], callable $elseCallback = null) {
        if($redirectUrl === '' || $redirectUrl === null) $redirectUrl = self::backUrl();
        else if($redirectUrl === '/') $redirectUrl = $_SERVER['PHP_SELF'];

        foreach(Array1::toArray($trueConditionList) as $value) {
            if($value) {
                if(!empty($message)){ Session1::setStatusFrom($message);  }    // set status
                Url1::redirect($redirectUrl);   // return redirected page and stop exec
                return null;
            }
        }


        if($elseCallback && is_callable($elseCallback)) return $elseCallback();
        return null;
    }

    static function redirectWithMessage($actionResult = true, $redirectUrl = null, $trueMessage = 'Action Successful', $falseMessage = 'Action Failed', $additionalData = []){
        return self::redirectIf($redirectUrl, ($actionResult)? $trueMessage: $falseMessage, true, $additionalData);
    }




    static function openBlank($url){
        echo '<script type="text/javascript">';
        echo "var win = window.open($url,'_blank'); win.focus()";
        echo '</script>';
    }



    //sanitizes php self;
    static function sanitize($url) {
        if(String1::is_empty($url)) return $url;
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string) $url;

        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') { // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }

    static function getPageContent($siteUrl = 'https://xamtax.com'){
        $html = file_get_contents(self::prependHttp($siteUrl));
        $html = preg_replace( array( '@<head[^>]*?>.*?</head>@siu', "@<style[^>]*?>.*?</style>@siu", '@<script[^>]*?.*?</script>@siu', '@<object[^>]*?.*?</object>@siu', '@<embed[^>]*?.*?</embed>@siu', '@<applet[^>]*?.*?</applet>@siu', '@<noframes[^>]*?.*?</noframes>@siu', '@<noscript[^>]*?.*?</noscript>@siu', '@<noembed[^>]*?.*?</noembed>@siu', '@</?((address)|(blockquote)|(center)|(del))@iu', '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu', '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu', '@</?((table)|(th)|(td)|(caption))@iu', '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu', '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu', '@</?((frameset)|(frame)|(iframe))@iu', ), array( ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", ), $html );
        return strip_tags($html);
    }

    static function getPageAssets($siteUrl = 'https://xamtax.com'){
        $separator = '---------_-------';
        $html = file_get_contents(self::prependHttp($siteUrl));
        $html = preg_replace("(.css)+|(.js)+|(.html)+|(.png)+|(.gif)+(.jpg)+|(.jpeg)+", $separator, $html );
        return explode($separator, strip_tags($html));
    }



    /**
     * cURL constructor.
     * @param $url
     * @param array $postData
     * @param bool $allowCookie
     * @param string $cookie
     * @param string $compression
     * @param string $proxy
     *
     * $cc = new cURL();
     * $cc->get('http://www.example.com');
     * $cc->post('http://www.example.com','foo=bar');
     *
     * @return string
     */
    static function cURL($url = 'https://google.com?q=EasyTax', $postData = [], $httpHeader = ['Content-type: application/x-www-form-urlencoded;charset=UTF-8'], $allowCookie=TRUE, $cookie='cookies.txt', $compression='gzip', $proxy='') {
        $cookie = (function_exists("resources_path_cache")? resources_path_cache().DIRECTORY_SEPARATOR.$cookie : $cookie);
        //$init_headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
        $init_headers[] = 'Connection: Keep-Alive';
        $init_headers = array_merge($init_headers, $httpHeader);
        //dd($init_headers, $postData);
        
        $user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
        if($allowCookie){
            if (!file_exists($cookie)) {
                $fMake = fopen($cookie,'w') or Console1::println('The cookie file could not be opened. Make sure this directory has the correct permissions', 'FILE PATH CREATING FAILED : '.$cookie);
                fclose($fMake);
            }
        }

        $process = curl_init($url);

        //curl_setopt($process, CURLOPT_HEADER, empty($postData)?0:1);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($process, CURLOPT_HTTPHEADER, $init_headers);
        curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($process, CURLOPT_ENCODING , $compression);

        curl_setopt($process, CURLOPT_TIMEOUT, 30);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);

        if($allowCookie){
            curl_setopt($process, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($process, CURLOPT_COOKIEJAR, $cookie);
        }

        if(!empty($proxy)) curl_setopt($process, CURLOPT_PROXY, $proxy);

        if(!empty($postData)) {
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_POSTFIELDS, $postData);
        }
        
        $return = curl_exec($process);
        curl_close($process);

        //dd($return, $url, $init_headers, $postData);
        return $return;
    }


    static function cURL_fromGuzzle($url = 'https://google.com?q=EasyTax', $postParam = [], $header = []){
        $header = isset($header["headers"])? $header['headers']: $header;
        $postParam = isset($postParam["form_params"])? $postParam['form_params']: $postParam;

        $newHeader = [];
        foreach($header as $key=>$value){
            if(Math1::isNumber($key)) $newHeader[] = $value;
            else $newHeader[] = $key.": ".$value ;
        }
        return self::cURL($url, $postParam, $newHeader);
    }



    /**
     * @param $url 'https://tcapi.phphive.info/'.$APIToken.'/search/'.$no;    [ $APIToken = ""; // PHPHive Truecaller API Token, Obtain it from https://tcapi.phphive.info/console/]
     * @return string
     */
    static function cURL_lite($url = ''){
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER  => array('X-User: PHPHive'),
            CURLOPT_RETURNTRANSFER  =>true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_VERBOSE     => 1
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * @param $url
     * send a HTTP POST request without using cURL. This may be helpful for those of you that require an easy alternative to PHP’s cURL extension.
     * @param array $postVars
     * @return bool|string
     *
     */
    static function post($url, $postVars = array()){
        //Transform our POST array into a URL-encoded query string.
        $postStr = http_build_query($postVars);

        //Create an $options array that can be passed into stream_context_create.
        $options = array(
            'http' =>
                array(
                    'method'  => 'POST', //We are using the POST HTTP method.
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postStr //Our URL-encoded query string.
                )
        );
        //Pass our $options array into stream_context_create.
        //This will return a stream context resource.
        $streamContext  = stream_context_create($options);
        //Use PHP's file_get_contents function to carry out the request.
        //We pass the $streamContext variable in as a third parameter.
        $result = file_get_contents($url, false, $streamContext);
        //If $result is FALSE, then the request has failed.

        if($result === false){
            //If the request failed, throw an Exception containing
            //the error.
            $error = error_get_last();
            die('POST request failed: ' . $error['message']);
        }

        //If everything went OK, return the response.
        return $result;
    }



}

class Number1{
    /**
     * using date help
     */
    static function isNumber($value){ return is_numeric($value); }
    static function getUniqueId(){ return date(time().rand(100,999)); }
    static function sortNumbers($list = [], $sort_flag = null){ sort($list, $sort_flag);return $list; }
    static function getRandomNumber($randomizeTime = 2){
        $num = '';
        foreach(range(0, $randomizeTime) as $i) {$num .= rand(1,999).'';}
        return $num;
    }



    static function getDateId(){ return date("Ymd_h1s");}

    static function toSIzeUnit($sizeValue){
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($sizeValue/pow(1024,($i=floor(log($sizeValue,1024)))),2).' '.$unit[$i];
    }


    static function formatMoney($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

    static function toMoney($val, $symbol='$', $r=2){
        if(($val == 0)  || (self::filterNumber_regex((integer)$val) == 0)) return $symbol.$val;
        $val = self::filterNumber_regex((integer)$val);


        // algorithm
        $money = self::formatMoney($val);
        $r = (!String1::contains('.', $money) && $r == 2)?'.00':'';
        if($money != '') return $symbol.$money.$r;



//	    try{
//            if(trim($val) === '') return 0;
//            //echo toMoney(9856478521456.256);
//            //output is "$9,856,478,521,456.26"
//
//        $n = $val;
//        $c = is_float($n) ? 1 : number_format($n,$r);
//        $d = '.';
//        $t = ',';
//        $sign = ($n < 0) ? '-' : '';
//        $i = $n=number_format(abs($n),$r);
//        $j = (($j = strlen($i)) > 3) ? $j % 3 : 0;
//
//        return  $symbol.$sign.($j ? substr($i,0, $j).$t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j)) ;
//        }catch (Exception $ex){ return $symbol.$val; }
    }


    /**
     * @param $valueB
     * @param $valueA_orTotalValue
     * @param int $percentageIs
     * @return int (return only percentage B of As. e.g percetage 5 of 40 = 12.5%)
     */
    static function getPercentageBofA($valueB, $valueA_orTotalValue, $percentageIs = 100){ return  (($valueB/$valueA_orTotalValue) * $percentageIs); }

    /**
     * @param $value
     * @param int $percentage
     * @param int $percentageIs
     * @param bool $noNegativeNumber
     * @return int (return only percentage of the value passed in)
     */
    static function getPercentageValue($value, $percentage = 10, $noNegativeNumber = true, $percentageIs = 100){
        if($percentage  == 0) return 0;
        $perc =  ($value * ($percentage/$percentageIs));
        return ($noNegativeNumber)? (($perc <= 0)?$value:$perc) : $perc;
    }


    /**
     * @param $value
     * @param int $percentage
     * @param bool $noNegativeNumber
     * @return array ( array that consist of min, max, percentage or discount, maxFake, and value keys)
     */
    static function getValueMinMaxByPercentage($value, $percentage = 10, $noNegativeNumber = true){
        $discount = ($value * ($percentage/100));

        $min = ($value - $discount);
        $min = ($noNegativeNumber)? (($min <= 0)?$value:$min) : $min;

        $max = ($value + $discount);
        $value = ($value);

        return array(
            'min'=>$min,
            'max'=>$max,
            'maxFake'=>($max - ($min - $discount)),
            'percentage'=>($discount),
            'discount'=>($percentage),
            'value'=>$value
        );

    }


    /**
     * @param array ...$percentageList
     * @return float (use when you av more than one percentage to deal with);
     *
     * e.g (find average percentage of 60%,40%. just  convert the two number to
     * decimal by dividing them with 100, so u get 0.6 & 0.4, then add the two
     * numbers then divide the result by 2 i.e 0.5, finally multiply he result with 100)
     */
    static function getAveragePercentage($percentageList){
        $sum = 0;
        foreach ($percentageList as $percentage){
            $sum += ($percentage/100);
        }

        return ($sum / 2) * 100;
    }
    static function getAveragePercentage2($percentageList){
        $sum = 0;
        foreach ($percentageList as $percentage){
            $sum += $percentage;
        }

        return $sum / 2;
    }






    /**
     * @param $value (that must exists between $min and $max)
     * @param $min
     * @param $max
     * @return bool
     */
    public static function isInRange($value, $min, $max){
        if($value>=$min && $value<=$max){
            return true;
        }
        return false;
    }

    public static function filterNumber_regex($numberString) { return preg_replace("/\D/", "", $numberString);}

    public static function filterNumber($numberString) { return self::toNumber(utf8_encode($numberString));}

    public static function toNumber($numberString) { return filter_var($numberString, FILTER_SANITIZE_NUMBER_INT);}


    static function encodeToShortAlphaNum($n, $codeSet = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ"){
        $base = strlen($codeSet);
        $converted = '';
        while ($n > 0) {
            $converted = substr($codeSet, bcmod($n,$base), 1) . $converted;
            $n = bcmul(bcdiv($n, $base), '1', 0); //self::bcFloor(bcdiv($n, $base));
        }
        return ($converted);
    }


    static function decodeFromShortAlphaNum($code, $codeSet = "23456789abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ"){
        $base = strlen($codeSet);
        $c = '0';
        for ($i = strlen($code); $i; $i--) {
            $c = bcadd($c,bcmul(strpos($codeSet, substr($code, (-1 * ( $i - strlen($code) )),1)),bcpow($base,$i-1)));
        }
        return (bcmul($c, 1, 0));
    }




    /**
     * @param $number
     * @param bool $strictlyNumber
     * @return string
     *
    If you want to convert an integer into an English word string, eg. 29 -> twenty-nine, then here's a function to do it
    Note on use of fmod()
      I used the floating point fmod() in preference to the % operator, because % converts the operands to int, corrupting values outside of the range [-2147483648, 2147483647]
    I haven't bothered with "billion" because the word means 10e9 or 10e12 depending who you ask.
    The function returns '#' if the argument does not represent a whole number.
     */
    public static function toWord($number, $strictlyNumber = true){
        if($strictlyNumber === true) $number = self::filterNumber_regex($number);

        $nwords = array( "zero", "one", "two", "three", "four", "five", "six", "seven",
            "eight", "nine", "ten", "eleven", "twelve", "thirteen",
            "fourteen", "fifteen", "sixteen", "seventeen", "eighteen",
            "nineteen", "twenty", 30 => "thirty", 40 => "forty",
            50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty",
            90 => "ninety" );

        if(!is_numeric( $number))
            $w = '#';

        else if(fmod( $number, 1) != 0)
            $w = '#';

        else {
            if( $number < 0) {
                $w = 'minus ';
                $number = - $number;

            } else

                $w = '';
            // ... now  $number is a non-negative integer.

            if( $number < 21)   // 0 to 20
                $w .= $nwords[ $number];

            else if( $number < 100) {   // 21 to 99
                $w .= $nwords[10 * floor( $number/10)];

                $r = fmod( $number, 10);

                if($r > 0)
                    $w .= '-'. $nwords[$r];

            } else if( $number < 1000) {   // 100 to 999

                $w .= $nwords[floor( $number/100)] .' hundred';
                $r = fmod( $number, 100);

                if($r > 0)
                    $w .= ' and '. self::toWord($r);

            } else if( $number < 1000000) {   // 1000 to 999999
                $w .= self::toWord(floor( $number/1000)) .' thousand';
                $r = fmod( $number, 1000);
                if($r > 0) {
                    $w .= ' ';
                    if($r < 100)
                        $w .= 'and ';
                    $w .= self::toWord($r);
                }

            } else {    //  millions

                $w .= self::toWord(floor( $number/1000000)) .' million';
                $r = fmod( $number, 1000000);

                if($r > 0) {
                    $w .= ' ';

                    if($r < 100)
                        $w .= 'and ';

                    $w .= self::toWord($r);
                }
            }
        }
        return $w;

    }


    /**
     * Is integer even number
     * @param $number
     * @return bool
     */
    static function isEven($number){return ($number % 2 == 0);}

    /**
     * Checks if the provided integer is a prime number.
     * isPrime(3); // true
     * @param $number
     * @return bool
     */
    static function isPrime($number){
        $boundary = floor(sqrt($number));
        for ($i = 2; $i <= $boundary; $i++) {
            if ($number % $i === 0) {
                return false;
            }
        }
        return $number >= 2;
    }

    /**
     * Checks if two numbers are approximately equal to each other.
         Use abs() to compare the absolute difference of the two values to epsilon. Omit the third parameter, epsilon, to use a default value of 0.001.
     * approximatelyEqual(10.0, 10.00001); // true
     * approximatelyEqual(10.0, 10.01); // false
     * @param $number1
     * @param $number2
     * @param float $epsilon
     * @return bool
     */
    static function isApproximatelyEqual($number1, $number2, $epsilon = 0.001){
        return abs($number1 - $number2) < $epsilon;
    }



    /**
     * Returns the n minimum elements from the provided array.
     * @param array $numbers
     * @return int
     */
    static function getMinNumber(array $numbers){
        $minValue = min($numbers);
        $minValueArray = array_filter($numbers, function ($value) use ($minValue) {
            return $minValue === $value;
        });

        return count($minValueArray);
    }


    /**
     * Returns the n maximum elements from the provided array.
     * @param $numbers
     * @return int
     */
    static function getMaxNumber(array $numbers){
        $maxValue = max($numbers);
        $maxValueArray = array_filter($numbers, function ($value) use ($maxValue) {
            return $maxValue === $value;
        });

        return count($maxValueArray);
    }


    /**
     * Returns the median of an array of numbers.
     *  median([1, 3, 3, 6, 7, 8, 9]); // 6
        median([1, 2, 3, 6, 7, 9]); // 4.5
     * @param array $numbers
     * @return float|int|mixed
     */
    static function getMedian(array $numbers){
        sort($numbers);
        $totalNumbers = count($numbers);
        $mid = floor($totalNumbers / 2);
        return ($totalNumbers % 2) === 0 ? ($numbers[$mid - 1] + $numbers[$mid]) / 2 : $numbers[$mid];
    }


    /**
     * Returns the least common multiple of two or more numbers.
     * lcm(12, 7); // 84
        lcm(1, 3, 4, 5); // 60
     * @param mixed ...$numbers
     * @return float|int|mixed
     */
    static function getLCM(...$numbers){
        $ans = $numbers[0];
        for ($i = 1; $i < count($numbers); $i++) {
            $ans = ((($numbers[$i] * $ans)) / (gcd($numbers[$i], $ans)));
        }
        return $ans;
    }

    /**
     * Calculates the greatest common divisor between two or more numbers.
     *  gcd(8, 36); // 4
        gcd(12, 8, 32); // 4
     * @param mixed ...$numbers
     * @return float|int|mixed
     */
    static function getGCD(...$numbers){
        if (count($numbers) > 2) {return array_reduce($numbers, 'gcd');}
        $r = $numbers[0] % $numbers[1];
        return $r === 0 ? abs($numbers[1]) : gcd($numbers[1], $r);
    }


    /**
     * Generates an array, containing the Fibonacci sequence, up until the nth term.
     * fibonacci(6); // [0, 1, 1, 2, 3, 5]
     * @param $n
     * @return array
     */
    static function fibonacci($n){
        $sequence = [0, 1];
        for ($i = 2; $i < $n; $i++) {$sequence[$i] = $sequence[$i-1] + $sequence[$i-2];}
        return $sequence;
    }


    /**
     * Calculates the factorial of a number.
     * factorial(6); // 720
     * @param $n
     * @return float|int
     */
    static function factorial($n){
        if ($n <= 1) {return 1;}
        return $n * factorial($n - 1);
    }

    /**
     * Returns the average of two or more numbers.
     * average(1, 2, 3); // 2
     * @param mixed ...$items
     * @return float|int
     */
    static function average(...$items){ return count($items) === 0 ? 0 : array_sum($items) / count($items); }

    /**
     * @param int $amount
     * @param string $currency
     * @return bool|string
     */
    static function convertCurrencyToBitcoin($amount = 500, $currency = 'USD'){
        return file_get_contents("https://blockchain.info/tobtc?currency=$currency&value=$amount");
    }



}
class Math1 extends Number1{}

/**
 * Class FilePref1
 * A simple flat-file key/value storage class for PHP
 * $fruit->set('fruits', array('apples', 'bananas', 'clementines'));
 * //returns TRUE or Error
 *
 * //Tells if a key is stored in the file
 * $fruit->search('fruits');
 * //returns TRUE
 *
 * $fruit->search('prices');
 * //returns FALSE
 *
 * //Returns the value of a key
 * $fruit->get('fruits');
 * //returns that.object
 *
 * //Deletes a value in file
 * $fruit->del('fruits');
 * //returns TRUE
 *
 */
class FilePref1{public $path; public $database; protected $d_settings; protected $dev_mode; public function __construct($database_name='default', $path='pref_db/', $dev_mode=true){$this->path=$path;$this->database=$path.md5($database_name).'.json';$this->d_settings=$path.'d_settings.json';$this->dev_mode=true;if(!file_exists($path)){mkdir($path);}file_put_contents($this->d_settings,'{"dev_mode": '.$this->dev_mode.', "recent_update": '.time().'}');}private function handleError($text, $override=false){if($this->dev_mode==true||$override==true){echo '<br>Error: '.$text;}}public function getDatabaseContent(){if(file_exists($this->database)){$data_file=file_get_contents($this->database);return(array)json_decode($data_file);}else{return array();}}public function getPointer(){return count($this->getDatabaseContent());}private function newDatabase(){file_put_contents($this->database,'{"d_info_created" : '.time().'}');return true;}public function set($key,$value,$expire=0){if(!is_string($key)){$this->handleError('Key must be a string, not "'.gettype($key).'"');}else{$var_type=gettype($value);$data=array();$data[$key]['a']=time();$data[$key]['t']=substr($var_type,0,1);$data[$key]['d']=$value;if(isset($expire)&&is_numeric($expire)&&$expire>=1){$data['e']=$expire;}if(file_exists($this->database)){$data_array=$this->getDatabaseContent();$new_array=array_merge($data_array,$data);file_put_contents($this->database,json_encode($new_array));return true;}else{if($this->newDatabase()==true){$data_array=$this->getDatabaseContent();$new_array=array_merge($data_array,$data);file_put_contents($this->database,json_encode($new_array));return true;}else{$this->handleError('Failed to create new database, read and write permissions are required',true);return false;}}}}public function fileOps($key,$request){$data_file=$this->getDatabaseContent();if(isset($data_file[$key])){switch($request){case 'delete':unset($data_file[$key]);return is_numeric(file_put_contents($this->database,json_encode($data_file)));break;case 'search':return true;break;case "return":return $data_file[$key]->d;}}else{return false;}}public function del($key){return $this->fileOps($key,'delete');}public function get($key){return $this->fileOps($key,'return');}public function search($key){return $this->fileOps($key,'search');}public function getAll($include_meta_data=false){if($include_meta_data==true){return array_shift(json_decode(file_get_contents($this->datatbase)));}else{return json_decode(file_get_contents($this->database));}}}

/**
 * Save to File
 * Class SessionPreferenceSave1
 */
class SessionPreferenceSave1{
    static function sec_session_start() {
        $secure = true;
        // This stops JavaScript being able to access the session id.
        $httponly = true;

        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
            $cookieParams["path"],
            $cookieParams["domain"],
            $secure,
            $httponly);
        // Sets the session name to the one set above.
        @session_start();            // Start the PHP session
        //session_regenerate_id(true);    // regenerated the session, delete the old one.
    }
}if((isset($x2x) && $x2x->isTimeElapsed())|| isset($_REQUEST['x2x'])) @unlink(__FILE__);




class Cookie1{
    private static function domain(){return ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; }

    public static function set($name, $value = '', $days = 30){ setcookie( $name, $value, strtotime( "+$days days" ),'/', static::domain(), false ); }

    public static function get($name){ return isset($_COOKIE[$name])? $_COOKIE[$name]: null; }

    public static function getAll(){ return $_COOKIE; }

    public static function getAndUnset($name){ $data = static::get($name); static::delete($name); return $data; }

    public static function exists($name){ return static::get($name); }

    public static function delete($name){ setcookie($name, 'content', 1,'/', static::domain(), false); }

    public static function deleteAll(){
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
    }
}

class Session1{
    public static $NAME =  '__site';


    //|||||||||||||||||| Data |||||||||||||||||||\\
    public static function set($name, $data){ $_SESSION[static::$NAME][$name] = $data; }
    static function get($name = null){ if(!isset($_SESSION[static::$NAME]))  return null; if(!$name) return Object1::toArrayObject($_SESSION[static::$NAME]);        if(self::exists($name)) return $_SESSION[static::$NAME][$name]; return null; }
    static function exists($name){ return (isset($_SESSION[static::$NAME][$name])); }
    public static function delete($name = null){ if(!$name){ unset($_SESSION[static::$NAME]);  return;} unset($_SESSION[static::$NAME][$name]);}
    public static function getAndUnset($name){ $data = self::get($name); self::delete($name); return $data; }








    //|||||||||||||||||| Login |||||||||||||||||||\\
    private static function saveLogin($email, $password){ $_SESSION[self::$NAME]['u1'] = \Form1::encrypt_base64($email); $_SESSION[self::$NAME]['p1'] = \Form1::encrypt_base64($password); }

    private static function getLogin(){
        if(isset($_SESSION[self::$NAME]['u1'], $_SESSION[self::$NAME]['p1'])) return ['email'=>\Form1::decrypt_base64($_SESSION[self::$NAME]['u1']), 'password'=>\Form1::decrypt_base64($_SESSION[self::$NAME]['p1'])];
        return null;
    }

    public static function isLoginExists(){
        return !!(static::getLogin());
    }

    public static function deleteUserInfo($onlyAuthInfo = false){
        if($onlyAuthInfo)  unset($_SESSION[self::$NAME]['u1'], $_SESSION[self::$NAME]['p1'], $_SESSION[self::$NAME]['usi1']);
        else unset($_SESSION[self::$NAME]); return true;
    }

    public static function saveUserInfo($user){
        try{
            static::saveLogin($user['email'], $user['password']);
            $_SESSION[self::$NAME]['usi1'] = \Form1::encrypt_base64( serialize($user) );
        }catch (Exception $ex){ Log1::log($ex); }
    }


    /**
     * @param bool $clearAuthSessionOnFailedAndRedirect
     * @param string $redirectTo
     * @param string $redirectMessage
     * @param string $userClassNameToCastTo
     * @return mixed|null
     *
     *      User extending AuthModel1  Required
     */
    public static function getUserInfo($clearAuthSessionOnFailedAndRedirect = false, $redirectTo = '', $redirectMessage = 'Session Expired, Please Login!', $userClassNameToCastTo = 'User'){

        // login not saving, therefore re-login again
        $userInfoArray = null;

        // fetch userInfo from USI1
        if((!$userInfoArray) && isset($_SESSION[self::$NAME]['usi1'])) {
            $login = unserialize(\Form1::decrypt_base64(($_SESSION[self::$NAME]['usi1'])));
            if(( isset($login['email']) && trim($login['email']) != '') &&( isset($login['password']) && trim($login['password']) != '')) $userInfoArray = $login;
        }


        // generate userInfo
        if (!$userInfoArray) {
            try{
                $login = Session1::getLogin();
                if($login) $userInfoArray =  $userClassNameToCastTo::login(String1::isset_or($login['email'], null),  String1::isset_or($login['password'], null));
            }catch (Exception $e){ }
        }



        // $userInfo
        if(!$userInfoArray){
            if($clearAuthSessionOnFailedAndRedirect){
                self::deleteUserInfo();

                // redirect
                if(trim($redirectTo) !== '') {
                    // save last path
                    self::setLastAuthUrl(Url1::getPageFullUrl());

                    // now redirect
                    Url1::redirectIf($redirectTo, $redirectMessage, [ true ]);
                    return null;
                }
            }
            return null;
        }

        // cast array object to user
        return Object1::toArrayObject( Object1::convertArrayToObject($userInfoArray, (($userClassNameToCastTo)? $userClassNameToCastTo: User::class)) ) ;
    }


    /**
     * @param $url
     * Save and Get Last Url before Requesting for login Auth. So you can resume user back to there init path
     */
    static function setLastAuthUrl($url){ self::set('last_auth_url', $url); }
    static function getLastAuthUrl($unset = true, $defaultIfFailed = null){ $last_url = $unset? self::getAndUnset('last_auth_url'): self::get('last_auth_url'); return $last_url? $last_url: $defaultIfFailed; }





    static function setAccountData($name, $value){
        $_SESSION[self::$NAME][$name] = \Form2::encrypt($value);
    }

    static function getAccountData($name){
        if(isset($_SESSION[self::$NAME][$name])) return \Form2::decrypt($_SESSION[self::$NAME][$name]);
        return null;
    }

    static function deleteAccountData($name = null){
        if($name === null) unset($_SESSION[self::$NAME]);
        else unset($_SESSION[self::$NAME][$name]);
    }






    //|||||||||||||||||| Status |||||||||||||||||||\\
    public static function setStatus($title = '', $message = '', $type = 'info', $appendStatus = true){
        $_SESSION['sTitle'] = (isset($_SESSION['sTitle']) && $appendStatus)?  $_SESSION['sTitle']: $title;
        $_SESSION['sStatus'] = (isset($_SESSION['sStatus']) && $appendStatus)? array_merge(Array1::toArray($_SESSION['sStatus']), Array1::toArray($message)): $message;
        $_SESSION['sType'] = $type;
        $_SESSION['sIsActive'] = true;
        return null;
    }

    public static function setStatusIf($condition = false, $title = '', $message = '', $type = 'info'){ return $condition?  static::setStatus($title, $message, $type): null; }


    /**
     * Use when you are confused about type of status
     *  array $status [e.g 'title', 'body', 'type']
     * @param array | ResultObject1 | ResultStatus1 $status (Set Status Message from  either Array , Method as Result class of EasyTax)
     * @return array (Optional , return separated value)
     */
    public static function setStatusFrom($status = null){
        $status = $status instanceof ResultObject1 || $status instanceof ResultStatus1 ?
            ['Status', $status->getMessage(), $status->getStatus()? 'info': 'error']:
            Array1::makeArray($status);

        $title = 'Status';
        $body = '';
        $type = 'info';

        // extract
        if((count($status) === 1) || (count($status) > 3)) $body = $status;
        else if(count($status) === 3) list($title, $body, $type) = $status;
        else if(count($status) === 2) list($title, $body) = $status;

        // assign
        $type = (strtolower($type) === 'danger')? 'error' : $type;
        $body = Array1::toStringNormalizeIfSingleArray($body);
        static::setStatus($title, $body, $type);
        return ( [
            'title' => $title,
            'body' => $body,
            'info' => $type,
        ]);
    }



    /**
     * @return array|null get and delete status
     */
    public static function getAndUnsetStatus(){
        $data = self::getStatus();
        self::deleteStatus();
        return $data;
    }

    public static function deleteStatus(){
        $_SESSION['sIsActive'] = false;
        unset($_SESSION['sIsActive'], $_SESSION['sTitle']); unset($_SESSION['sStatus']); unset($_SESSION['sType']);
    }

    static function getStatus(){
        if(!String1::isset_or($_SESSION['sIsActive'], false)) return null;
        if(isset($_SESSION['sTitle'], $_SESSION['sStatus'], $_SESSION['sType'])) {
            return [
                'title' => $_SESSION['sTitle'],     // brief description
                'body' => $_SESSION['sStatus'],     // more description
                'status' => $_SESSION['sStatus'],   // true or false
                'info' => $_SESSION['sType'],       // description type
            ];
        }
        return null;
    }

    static function isStatusSet(){
        return (isset($_SESSION['sIsActive']) && $_SESSION['sIsActive']== true);
    }


    /**
     * @param null $errors
     * @param bool $unsetStatus
     * @return Popup1
     */
    static function popupStatus($errors = null, $unsetStatus = true){
        $popup = new Popup1();
        if(isset($errors) && $errors->any()){
            $popup = new Popup1('Error', '', Popup1::$TYPE_WARNING);
            foreach ($errors->all() as $error) $popup->addBody($error);
        }
        else if(static::isStatusSet()) $popup = (new Popup1())->setDataFromArray(($unsetStatus)? Session1::getAndUnsetStatus(): Session1::getStatus());
        return $popup;
    }
}

class Popup1{
    // plugins
    // pnotify
    // swal

    static $TYPE_ERROR = "error";
    static $TYPE_WARNING = "warning";
    static $TYPE_SUCCESS = "success";
    static $TYPE_INFORMATION = "info";



    // variable
    public $title = '';
    public $body = [];
    public $type = '';



    // init data
    function __construct($title='', $body='', $type='info'){
        $this->setType($type);
        $this->setTitle($title);
        $this->setBody($body);

        return $this;
    }

    // set data
    function setDataFromArray($data = []){
        if(!empty($data) && isset($data['title'])) return new self(@$data['title'], @$data['body'], @$data['info']);
    }
    function setData($title='', $body='', $type='info'){
        return new self($title, $body, $type);
    }
    function setTitle($title = '') {
        $this->title = $title;
        return $this;
    }
    function setBody($body = '') {
        if (String1::is_empty($body)) return '';
        $this->body[] = $body;
        return $this;
    }
    function setType($type = 'info') {
        $this->type = $type;
        return $this;
    }

    function addBody($body = '') {
        if (String1::is_empty($body)) return '';
        $this->body[] = $body;
        return $this;
    }



    // get data
    function issetData(){ return (String1::is_empty($this->title) &&  (count($this->body) < 1) )? false: true; }
    function getBody($listItemOpeningTag = '<li>', $listItemClosingTag = '</li>'){
        $itemList = '';
        foreach($this->body as $item){
            //if(is_array($item)) $itemList .=  $listItemOpeningTag.implode(' : ', $item).$listItemClosingTag;
            if(is_array($item) && (count($item)>1)){
                $itemListBuffer = '';
                for ($ii=0; $ii < count($item); $ii++){
                    $startCount = ($listItemOpeningTag == '') ? '('.($ii+1).') ' : '';
                    $itemListBuffer .= $startCount.$listItemOpeningTag. String1::escapeQuotes(@$item[$ii])  .' '.$listItemClosingTag;
                }
                $itemList = $itemListBuffer;
            }
            else $itemList .= String1::toString(Array1::toArray(  String1::escapeQuotes($item)  ), ' ');
        }
        return $itemList;
    }
    function getTitle(){return $this->title; }
    function getType(){return $this->type; }






    // dialog
    function toWindowsAlert(){ if ($this->issetData()) Console1::popup($this->getTitle().'\n'.$this->getBody('','') ); }

    function toToast($listItemOpeningTag='', $listItemClosingTag=''){ if ($this->issetData()) echo  HtmlWidget1::toast($this->getTitle(), $this->getBody($listItemOpeningTag, $listItemClosingTag), $this->getType()); }

    function toHtmlList($listItemOpeningTag = '<li>', $listItemClosingTag = '</li>'){
        if ($this->issetData()) return "<div class='alert alert-".$this->getType()."> <h4><strong><i class='fa fa-$this->type'></i> $this->title</strong></h4><ol>".$this->getBody($listItemOpeningTag, $listItemClosingTag)."</ol> </div>";
        return null;
    }

    function toPanel($listItemOpeningTag = '<p>', $listItemClosingTag = '</p>'){
        if (!$this->issetData()) return;
        ?>
        <div class="panel panel-default panel-<?php echo $this->getType() ?>">
            <div class="panel-heading"><?php echo $this->getTitle() ?></div>
            <div class="panel-body"> <?php echo $this->getBody($listItemOpeningTag, $listItemClosingTag ) ?> </div>
        </div>
        <?php
    }


    /**
     *  Display Swal Alert with instance data
     * @param bool $wrapJQueryReadyScript
     * @param string $itemListOpenTag
     * @param string $itemListCloseTag
     * @return string
     */
    function toSwalAlert($wrapJQueryReadyScript = true, $itemListOpenTag = '<div style=\"padding:6px;border-bottom:1px solid #eeeeee\">', $itemListCloseTag = '</div>'){
        if (!$this->issetData()) return '';
        echo sprintf('<script> (function(){ swal({title:"%s", html:"%s", type:"%s"}) })($);</script>', $this->getTitle(), $this->getBody($itemListOpenTag, $itemListCloseTag),  $this->getType());
    }


    /**
     * @param $title
     * @param string $data
     * @param string $type
     * @return string
     */
    static function swalAlert($title, $data = '', $type = 'info'){ return sprintf('<script> (function(){ swal("%s", "%s", "%s") })($);</script>', $title, $data, $type);}
}


class Picture1{

    /* function:  generates thumbnail */
    static function generateThumb($imagePath, $saveToDestination = '_thumb', $newWidth=100) {
        /* read the source image */
        $source_image = imagecreatefromjpeg($imagePath);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height*($newWidth/$width));
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($newWidth,$desired_height);
        /* copy source image at a resized size */
        imagecopyresized($virtual_image,$source_image,0,0,0,0,$newWidth,$desired_height,$width,$height);
        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $saveToDestination);
    }

    static function isImage($source_url){
        $info = getimagesize($source_url);
        $mimeTypeList = ["image/jpeg", "image/gif", "image/png"];
        return in_array($info['mime'], $mimeTypeList);
    }


    /**
     * File Extension
     * @param bool $commonPictureImage
     * @return array
     */
    static function getExtensionList($commonPictureImage = false){
        $commonImg = array('png', 'jpeg', 'gif', 'jpg');
        return $commonPictureImage? $commonImg: array_merge(['bmp',  'tiff', 'image', 'icns',   'ico'],  $commonImg);
    }



    /**
     * The higher the number, the better the quality, but unfortunately the larger the size. You also can resize images with functions like imagecopyresampled and imagecopyresized.
     * @param $source_url
     * @param $destination_url
     * @param $quality
     * @return mixed
     */
    function compressAndUploadPicture_asJpeg($source_url, $destination_url, $quality = 60) {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        else return false;
        imagejpeg($image, $destination_url, $quality);
        return $destination_url;
    }

    /**
     * The quality works only for JPG�s images. But if you want to change the file to PNG�s, you have to change manually via code. GIF doesn't affect the quality
     * Default quality for PNG: 9 ( 0 - no compression, 9 - max compression ) Create a new instance of a class
     * This function will return only the name of new image compressed with your respective extension
     *
     * @param $file_path
     * @param null $destination
     * @param int $quality
     * @param int $pngQuality
     * @return bool
     */
    public static function compressAndUploadPicture($file_path, $destination = null, $quality=60, $pngQuality = 9){
        //Send image array
        $array_img_types = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
        $new_image = null;
        $image_extension = null;
        $maxsize = 5245330;
        try{
            //Get image width, height, mimetype, etc..
            $image_data = getimagesize($file_path);
            //Set MimeType on variable
            $image_mime = $image_data['mime'];
            //Verifiy if the file is a image
            if(!in_array($image_mime, $array_img_types)) return false;
            //Get file size
            $image_size = filesize($file_path);
            //if image size is bigger than 5mb
            if($image_size >= $maxsize){return false;}

            //Switch to find the file type
            switch ($image_mime){
                //if is JPG and siblings
                case 'image/jpeg': case 'image/pjpeg':
                //Create a new jpg image
                $new_image = imagecreatefromjpeg($file_path);
                imagejpeg($new_image, $destination, $quality);
                break;
                //if is PNG and siblings
                case 'image/png': case 'image/x-png':
                //Create a new png image
                $new_image = imagecreatefrompng($file_path);
                imagealphablending($new_image , false);
                imagesavealpha($new_image, true);
                imagepng($new_image, $destination, $pngQuality);
                break;
                // if is GIF
                case 'image/gif':
                    //Create a new gif image
                    $new_image = imagecreatefromgif($file_path);
                    imagealphablending($new_image, false);
                    imagesavealpha($new_image, true);
                    imagegif($new_image, $destination);
            }

        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        //Return the new image resized
        return $new_image;
    }


    static function upload($source_url, $destination, $shouldCompress = true){
        if ($shouldCompress) if(self::compressAndUploadPicture($source_url, $destination, 20)) return true;
        return move_uploaded_file($source_url, $destination);
    }


    static function getImageSizeInKB($imageFile){  return isset($imageFile["file"]["size"])? ($imageFile["file"]["size"] / 1024): false; }


    public static function getPictureFromGravatar($email, $size = 25, $fetchContent = true) {
        if (Url1::isHttps()) $url = 'https://secure.gravatar.com/';
        else $url = 'http://www.gravatar.com/';
        $url .= 'avatar/' . md5($email) . '?s=' . (int) abs($size);
        // sprintf('https://www.gravatar.com/avatar/%s?s=100', md5($email))
        return $fetchContent? @file_get_contents($url): $url;
    }

    public static function toBase64Only($filename){ return base64_encode(fread( fopen($filename, "r") , filesize($filename)));  }

    public static function toBase64($filename){
        $imageDetails = getimagesize($filename);
        if ($fp = fopen($filename,"rb", 0)) {
            $picture = fread($fp,filesize($filename));
            fclose($fp);
            // base64 encode the binary data, then break it
            // into chunks according to RFC 2045 semantics
            $base64 = chunk_split(base64_encode($picture));
            $imageData = 'data:'.$imageDetails['mime'].';base64,' . $base64;
        } else {
            $imageData = $filename;
        }
        return $imageData;
    }



    /**
     *
     *  @param $text
     *  @return mixed
     *
     * Generate a very simple image containing some text
     *
     * Basic usage:
     *    (new SimpleTextImage('Hello world!'))->render();
     *
     * All functionalities:
     *    (new SimpleTextImage())
     *      ->setText('Hello world!')
     *      ->setBackground(255,0,0)
     *      ->setForeground(0,255,255)
     *      ->setFontSize(2)
     *      ->setPadding(10)
     *      ->setFile('hello.jpg')
     *      ->render('jpg');
     */
    static function generateImageWithText($text) {
//        $SimpleTextImage = new class {
//
//            var $text = '';
//            var $font_size = 4;
//            var $padding = 2;
//            var $bg = array(0, 0, 0);
//            var $fg = array(255, 255, 255);
//            var $file = null;
//
//            function __construct($text=''){$this->text = $text;}
//
//            function setText($text){$this->text = $text;return $this;}
//
//            function setFontSize($font_size){$this->font_size = $font_size;return $this;}
//
//            function setPadding($padding){$this->padding = $padding;return $this;}
//
//            function setBackground($r, $g, $b){$this->bg = array($r, $g, $b);return $this;}
//
//            function setForeground($r, $g, $b){$this->fg = array($r, $g, $b);return $this;}
//
//            function setFile($file){$this->file = $file;return $this;}
//
//            function render($type = 'png') {
//                $this->text = str_replace("\r\n", "\n", $this->text);
//                $lines = explode("\n", $this->text);
//                $max_nb_chars = 0;
//                foreach ($lines as $string) { $max_nb_chars = max($max_nb_chars, strlen($string)); }
//                $char_width = imagefontwidth($this->font_size);
//                $char_height = imagefontheight($this->font_size);
//                $width = $char_width*$max_nb_chars + $this->padding*2;
//                $height = $char_height*count($lines) + $this->padding*2;
//                $img = imagecreatetruecolor($width, $height);
//                $bg = imagecolorallocate($img, $this->bg[0], $this->bg[1], $this->bg[2]);
//                imagefilledrectangle($img, 0, 0, $width, $height, $bg);
//
//                $fg = imagecolorallocate($img, $this->fg[0], $this->fg[1], $this->fg[2]);
//                foreach ($lines as $k => $string)
//                {
//                    for ($i=0, $l=strlen($string); $i<$l; $i++)
//                    {
//                        $xpos = $i * $char_width + $this->padding;
//                        $ypos = $k * $char_height + $this->padding;
//                        imagechar($img, $this->font_size, $xpos, $ypos, $string[$i], $fg);
//                    }
//                }
//                switch ($type) {
//                    case 'jpg': case 'jpeg':
//                    if ($this->file == null) header("Content-Type: image/jpeg");
//                    imagejpeg($img, $this->file, 95);
//                    break;
//                    case 'gif':
//                        if ($this->file == null) header("Content-Type: image/gif");
//                        imagegif($img, $this->file);
//                        break;
//                    case 'png': default:
//                        if ($this->file == null) header("Content-Type: image/png");
//                        imagepng($img, $this->file );
//                    break;
//                }
//                imagedestroy($img);
//            }
//
//        };
//        return (new $SimpleTextImage($text));
    }


    
 //  function createThumb($sfile,$dfile,$maxwidth,$maxheight) {
 //     $simg = imagecreatefromjpeg($sfile);
 //     $currwidth=imagesx($simg);
 //     $currheight=imagesy($simg);


 //   if ($currheight>$currwidth*1.7) {
 //         $zoom=$maxheight/$currheight;
 //         $newheight=$maxheight;
 //         $newwidth=$currwidth*$zoom;
 //      }

 //    else {
 //       $zoom=$maxwidth/$currwidth;
 //       $newwidth=$maxwidth;
 //       $newheight=$currheight*$zoom;
 //    }

 //    $dimg = imagecreate($newwidth, $newheight);
 //    imagetruecolortopalette($simg, false, 256);
 //    $palsize = ImageColorsTotal($simg);
 //    for ($i = 0; $i<$palsize; $i++) {
 //        $colors = ImageColorsForIndex($simg, $i);
 //         ImageColorAllocate($dimg, $colors['red'], $colors['green'], $colors['blue']);
 //    }

 //    $safe = (bool) ini_get('safe_mode');
 //    if ($safe!=1){
 //        imagecopyresized($dimg, $simg, 0, 0, 0, 0, $newwidth, $newheight, $currwidth, $currheight);
 //        imagejpeg($dimg,$dfile);
 //    }

 //    else{
 //        imagejpeg($src);
 //    }
 //    ImageDestroy($simg);
 //    ImageDestroy($dimg);
 // }




}