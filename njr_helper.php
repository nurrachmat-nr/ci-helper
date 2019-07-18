<?php
/**
 * @package         njr_helper
 * @subpackage      Helper
 * @author          Nur Rachmat <rachmat.nur91@gmail.com>
 * @version         0.1
 * @copyright       Copyright © 2017 Nur Rachmat <rachmat.nur91@gmail.com>
 */

/**
 * @TODO : check the way of accessing some page
 * Usage is_direct() ? check_referrer('your_controller') : true
 */

if( ! function_exists('check_referrer')){
    /**
     * Check incoming (referrer) site
     * @param  string $controller
     */
    function check_referrer($controller, $is_admin = false){
        $CI =& get_instance();
        //if come from another site or direct access
        if($CI->agent->is_referral() || strlen($CI->agent->referrer()) == 0)
        {
            m_error("Direct access not allowed !<br/>
            Dilarang mengakses langsung ke halaman <b>Add, Edit, Delete</b> dari situs lain atau akses langsung tanpa melalui hyperlink!");
            //direct to proper page (controller)
            if(function_exists('adminredirect') && $is_admin == true){
                adminredirect($controller, 'refresh');
            }else{
                redirect($controller, 'refresh');
            }

        }
    }
}

if( ! function_exists('is_direct')){
    /**
     * Check the request is direct access to some mapped page (function)
     * @return bool
     */
    function is_direct(){
        $CI =& get_instance();
        //default list no direct access
        $nodirect = array('add', 'edit', 'remove');
        $accessto = $CI->uri->segment(2, 'index');
        $accessto_seg3 = $CI->uri->segment(3, 'index');
        return in_array($accessto, $nodirect) || in_array($accessto_seg3, $nodirect);
        //if true, must be blocked, else its allowed
    }
}

if(!function_exists('direct_to')){
    /**
     * As same as redirect with ability check page referrer and direct to last page
     * @param string $controller
     */
    function direct_to($controller = ''){
        $CI =& get_instance();
        if (!$CI->agent->is_referral()) //if same site (host)
        {
            if($CI->agent->referrer() != '')    //Go back to last page
                redirect($CI->agent->referrer(), 'refresh');
            elseif($controller == '')           //Go back to last page if no target (controller)
                redirect($CI->agent->referrer(), 'refresh');
            else
                redirect($controller, 'refresh');

        }else{  //come from another site
            redirect('', 'refresh');
        }
    }
}

//FORM Helper
if ( ! function_exists('clean_input')){
    /**
     * Clean and sanitize input post element, doing strip_tags and trim
     * @param string $name
     *
     * @return null|string
     */
    function clean_input($name = ''){
        $CI =& get_instance();
        return (is_null($CI->input->post($name))) ? null : strip_tags(trim($CI->input->post($name)));
    }
}

//Populate form element values and state
if ( ! function_exists('set_selected'))
{
    /**
     * Set combo box state, compared by value from database
     * @param string $field
     * @param string $value
     * @param null   $valuedb
     * @param bool   $default
     *
     * @return string
     */
    function set_selected($field = '', $value = '', $valuedb = NULL, $default = FALSE)
    {

        if ( ! isset($_POST[$field]))
        {
            if (count($_POST) === 0 AND $default == TRUE)
            {
                return ' selected="selected"';
            }

            if( ! is_null($valuedb)){
                if($value == $valuedb){
                    return ' selected="selected"';
                }
            }
            return '';
        }

        $field = $_POST[$field];



        if (is_array($field))
        {
            if ( ! in_array($value, $field))
            {
                return '';
            }
        }
        else
        {
            if (($field == '' OR $value == '') OR ($field != $value))
            {
                return '';
            }
        }

        return ' selected="selected"';

    }
}

if ( ! function_exists('set_checked'))
{
    /**
     * Set radio button and checkbox state, compared by value from db
     * @param string $field
     * @param string $value
     * @param null   $valuedb
     * @param bool   $default
     *
     * @return string
     */
    function set_checked($field = '', $value = '', $valuedb = NULL, $default = FALSE)
    {

        if ( ! isset($_POST[$field]))
        {
            if (count($_POST) === 0 AND $default == TRUE)
            {
                return ' checked="checked"';
            }

            if( ! is_null($valuedb)){
                if($value == $valuedb){
                    return ' checked="checked"';
                }
            }
            return '';
        }

        $field = $_POST[$field];

        if (is_array($field))
        {
            if ( ! in_array($value, $field))
            {
                return '';
            }
        }
        else
        {
            if (($field == '' OR $value == '') OR ($field != $value))
            {
                return '';
            }
        }
        return ' checked="checked"';
    }
}


//BOOTSTRAP
/**
 * Show Bootstrap Alert Success Box
 * @param string $msg Message to display
 * @param boolean $dismis
 */
function alert_success($msg, $dismis = FALSE){
    if($msg != ""){
        if($dismis)
            $ex = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        else
            $ex = "";

        echo "<div class=\"alert alert-success ".(($dismis) ? 'alert-dismissible': '')."\" role=\"alert\">
                {$ex}
                    <i class='fa fa-info-circle'></i> {$msg}
                </div>";
    }
}

/**
 * Show Bootstrap Alert Info Box
 * @param string $msg Message to display
 * @param boolean $dismis
 */
function alert_info($msg, $dismis = FALSE){
    if($msg != ""){
        if($dismis)
            $ex = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        else
            $ex = "";
        echo "<div class=\"alert alert-info ".(($dismis) ? 'alert-dismissible': '')."\" role=\"alert\">
                {$ex}
                    <i class='fa fa-info-circle'></i> {$msg}
                </div>";
    }
}
/**
 * Show Bootstrap Alert Danger Box
 * @param string $msg Message to display
 * @param boolean $dismis
 */
function alert_danger($msg, $dismis = FALSE){
    if($msg != ""){
        if($dismis)
            $ex = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        else
            $ex = "";

        echo "<div class=\"alert alert-danger ".(($dismis) ? 'alert-dismissible': '')."\" role=\"alert\">
                {$ex}
                    <i class='fa fa-exclamation-circle'></i> {$msg}
                </div>";
    }
}

/**
 * Show Bootstrap Alert Warning Box
 * @param string $msg Message to display
 * @param boolean $dismis
 */
function alert_warning($msg, $dismis = FALSE){
    if($msg != ""){
        if($dismis)
            $ex = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        else
            $ex = "";

        echo "<div class=\"alert alert-warning ".(($dismis) ? 'alert-dismissible': '')."\" role=\"alert\">
                {$ex}
                    <i class='fa fa-warning'></i> {$msg}
                </div>";
    }
}
//End Bootstrap Alert

/**
 * Shoe bootstrap label
 * @param string $msg
 * @param string $color 'success/default/danger/warning/info'
 * @param string $size "xs,sm,md,lg
 * @return string
 */
function label($msg, $color='success', $size = ''){
    return "<span class=\"label label-{$color} {$size}\">{$msg}</span>";
}

/**
 * Delete Hyperlink with Confirmation
 * @param string url
 */
function confirmation_delete($url){
    echo "<a class=\"btn btn-warning btn-xs\" data-toggle=\"confirmation\"
        data-title=\"Anda yakin ingin menghapus?\" 
        data-singleton=\"true\" 
        data-popout=\"true\"
        data-btn-ok-label=\"Ya\"
        data-btn-cancel-label=\"Tidak\"
        data-placement=\"left\" 
        href=\"".$url."\" ><i class=\"fa fa-trash\"></i> Hapus</a>";
}
/**
 * Delete Icon with Confirmation (need Admin LTE .btn-box-tool )
 * @param string url
 * @param string q Question? Conf Message
 * @param string lang Language id/en
 */
function confirmation_delete_icon($url, $q=null, $lang = "id", $place = "left"){
    echo "<a class=\"btn btn-box-tool btn-xs\" data-toggle=\"confirmation\"
        data-title=\"".(($q == '') ? 'Anda yakin ingin menghapus?' : $q)."\" 
        data-singleton=\"true\" 
        data-popout=\"true\"
        data-btn-ok-label=\"".(($lang == "id") ? "Ya" : "Yes")."\"
        data-btn-cancel-label=\"".(($lang == "id") ? "Tidak" : "No")."\"
        data-placement=\"".$place."\" 
        href=\"".$url."\" ><i class=\"fa fa-trash\"></i></a>";
}


/**
 * Label Status Aktif/Tidak Aktif
 * @param boolean status
 * @return string
 */
function status_label($status=true){
    if($status == false || $status == 0){
        return label("Tidak Aktif", "warning", "sm");
    }elseif ($status == true || $status == 1){
        return label("Aktif", "success", "sm");
    }
    return label("N/A", "info", "sm");
}
//END BOOTSTRAP


//FILE UPLOADER
if ( ! function_exists('upload_file'))
{
    /**
     * File Uploader Helper
     * @param string $fname     form input name
     * @param array  $config    file upload configuration array
     *
     * @return array
     */
    function upload_file($fname = 'file', $config = array()){
        $CI =& get_instance();

        @mkdir($config['upload_path'],'755', true);
        $CI->load->library('upload');
        $CI->upload->initialize($config, FALSE);
        if ( ! $CI->upload->do_upload($fname)){
            $error = $CI->upload->display_errors("<p>","</p>");
            return array('success'=>FALSE, 'error'=>$error);
        }else{
            $data = $CI->upload->data();
            $params = array(
                $fname => $data['file_name'],
            );
            return array('success'=>TRUE, 'params'=>$params, 'data'=>$data);
        }
    }
}

/*
 * @TODO : get list record from database
 * table and model name must be
 * Table Name : tbl_name
 * Model name: Tbl_name_model
 *
 */
/**
 * Getting list of data that could be a reference such as combo box, select box etc
 * Function Name : get_all_tbl_name
 * @param string $module
 * @param string $table
 *
 * @return mixed
 */
function get_list_data($module = '',$table = ''){
    $CI =& get_instance();
    $model      = "m{$table}";
    $model_p    = ucfirst($table);
    $model_file = ($module != '') ? "{$module}/{$model_p}_model" : "{$model_p}_model";

    $CI->load->model(array($model_file    =>  $model));
    $func   = "get_all_{$table}";
    return $CI->{$model}->{$func}();
}

/**
 * Get list record data filtered by where clause
 * Function Name : get_all_data_where(table, where, field(s), limitparam)
 * @param string $module
 * @param string $table
 * @param array $where
 * @param array $params
 *
 * @return mixed
 */
function get_list_data_where($module = 'common', $table = '', $where= array(),  $select = '*', $params = array()){
    $CI =& get_instance();
    $model      = "m{$table}";
    $model_file = ($module != '') ? "{$module}/Query_model" : "Query_model";
    $CI->load->model(array($model_file    =>  $model));
    $func   = "get_all_data_where";

   try{
       return $CI->{$model}->{$func}($table, $where, $select, $params);
   }catch (Exception $e){
       return $CI->{$model_file}->{$func}($table, $where, $select, $params);
   }

    //return $CI->{$model}->{$func}($table, $where, $select, $params);
}
/**
 * Get single record data filtered by where clause
 * Function Name : get_data_where(table, where)
 * @param string $module
 * @param string $table
 * @param array $where
 * @param array $select
 *
 * @return mixed
 */
function get_data_where($module = 'common', $table = '', $where= array(), $select = '*'){
    $CI =& get_instance();
    $model      = "m{$table}";
    $model_file = ($module != '') ? "{$module}/Query_model" : "Query_model";

    $CI->load->model(array($model_file    =>  $model));
    $func   = "get_data_where";

    try{
        return $CI->{$model}->{$func}($table, $where, $select);
    }catch (Exception $e){
        return $CI->{$model_file}->{$func}($table, $where, $select);
    }
}

/**
 * Get record data by id (key)
 * Function Name : get_tbl_name($key)
 * @param string $module
 * @param string $table
 * @param array $where
 *
 * @return mixed
 */
function get_data($module = '', $table = '', $key =''){
    $CI =& get_instance();
    $model      = "m{$table}";
    $model_p    = ucfirst($table);
    $model_file = ($module != '') ? "{$module}/{$model_p}_model" : "{$model_p}_model";


    $CI->load->model(array($model_file    =>  $model));
    $func   = "get_{$table}";

    if(function_exists($func))
        return $CI->{$model}->{$func}($key);
    else
        return $CI->{$model_file}->{$func}($key);
}

function get_list_data_query($module = '', $query = '', $arr_bind = array()){
    $CI =& get_instance();
    $model      = "m_query";
    $model_file = ($module != '') ? "{$module}/query_model" : "query_model";

    $CI->load->model(array($model_file    =>  $model));
    $func   = "get_all_data_query";
    return $CI->{$model}->{$func}($query, $arr_bind);
}

function get_data_query($module = '', $query = '', $arr_bind = array()){
    $CI =& get_instance();
    $model      = "m_query";
    $model_file = ($module != '') ? "{$module}/query_model" : "query_model";

    $CI->load->model(array($model_file    =>  $model));
    $func   = "get_data_query";
    return $CI->{$model}->{$func}($query, $arr_bind);
}


/**
 * Konversi nominal bilangan besar
 * @param integer $nominal
 * @return string
 */
function convert_bilangan($nominal){
    if ($nominal < 1000000) {
        // Anything less than a million
        $n_format = number_format($nominal, 2, ',', '.');
    } else if ($nominal < 1000000000) {
        // Anything less than a billion
        $n_format = number_format($nominal / 1000000, 4, ',', '.') . ' Juta';
    } else {
        // At least a billion
        $n_format = number_format($nominal / 1000000000, 4, ',', '.') . ' Milyar';
    }
    return $n_format;
}

/* FOR DEBUGGING PURPOSE */
function last_query(){
    $CI =& get_instance();
    echo $CI->db->last_query();
}

/*=====================================================================================*/

if(! function_exists('authenticate')){

    /**
     * Cek status login User, jika tidak maka keluarkan
     */
    function authenticate(){
        $CI =& get_instance();
        if(is_null($CI->session->userdata(config_item('login'))) || $CI->session->userdata(config_item('login')) === false){
            m_error('You must <strong>Login</strong> to access the page');
            redirect('login', 'refresh');
        }
    }
}

if(! function_exists('get_level')){

    /**
     * Cek level login
     */
    function get_level(){
        $CI =& get_instance();
        return $CI->session->userdata(config_item('level'));
    }
}

if(! function_exists('get_id_user')){

    /**
     * Cek id user login
     */
    function get_id_user(){
        $CI =& get_instance();
        return $CI->session->userdata(config_item('iduser'));
    }
}



if(! function_exists('has_privileges')){

    /**
     * Cek privileges untuk mengakses halaman tertentu, dipisahkan per moduul
     */
    function has_privileges(){
        $CI =& get_instance();
        $priv = $CI->session->userdata('user_privileges');
        $mod = $CI->uri->segment(1, NULL);
        $has_p = false;
        if($priv == '2'){           //pic
            $has_p =  ($mod == 'pic');
        }elseif ($priv == '3'){     //pic/dispather
            $has_p =  ($mod == 'pic' || $mod == 'dispatcher');
        }elseif ($priv == '4'){     //dispatcher
            $has_p =  ($mod == 'dispatcher');
        }elseif ($priv == '6'){     //admin
            $has_p =  ($mod == 'admin');
        }elseif ($priv == '7'){     //dispatcher
            $has_p =  ($mod == 'dispatcher');
        }elseif ($priv == '8'){
            $has_p =  ($mod == 'pic');
        }

        if($has_p == false) redirect(get_module(),'refresh');
    }
}

if(! function_exists('get_module')){
    /**
     * Mendapatkan module yang sedang diakses oleh pengguna
     * @return mixed
     */
    function get_module(){
        $CI =& get_instance();
        return is_null($CI->session->userdata('module')) ? 'login' : $CI->session->userdata('module');
    }
}

if(! function_exists('get_year')){
    /**
     * GET this YEar
     * @return string
     */
    function get_year(){
        return date('Y');
    }
}


if (! function_exists('m_error')){

    /**
     * Set flash data for error messages
     * @param string $msg
     */
    function m_error($msg = ''){
        $CI =& get_instance();
        if($msg !='')
            $CI->session->set_flashdata('m_error', $msg);
    }
}

if (! function_exists('m_success')){

    /**
     * Set flash data for success messages
     * @param string $msg
     */
    function m_success($msg = ''){
        $CI =& get_instance();
        if($msg !='')
            $CI->session->set_flashdata('m_success', $msg);
    }
}


if (! function_exists('show_m_error')){

    /**
     * Show error message from m_error flash data
     * @param boolean $dismis If true, dismisable an vice versa
     */
    function show_m_error($dismis = FALSE){
        $CI =& get_instance();
        //$msg = $CI->session->flashdata('m_error')
        if($CI->session->flashdata('m_error')){
            alert_danger($CI->session->flashdata('m_error'), $dismis);
        }
    }
}

if (! function_exists('show_m_success')){

    /**
     * Show success message from m_success flash data
     * @param boolean $dismis
     */
    function show_m_success($dismis = FALSE){
        $CI =& get_instance();
        if($CI->session->flashdata('m_success')){
            alert_success($CI->session->flashdata('m_success'), $dismis);
        }
    }
}

/**
 * Get useerdata value from Session
 * @param string $key Nama session
 * @return string
 */
function user_data($key){
    $CI =& get_instance();
    return $CI->session->userdata($key);
}

/**
 * Get header form file
 * @param string $url
 * @return boolean
 */
function UR_exists($url){
    $headers= @get_headers($url);
    return stripos($headers[0],"200 OK")?true:false;
}

/**
 * Get Resource URL
 * @param string $path Path to file/resources
 * @param string $default Default file if file in path not found (not exits)
 * @return string
 * */
function res_url($path, $default){
    return UR_exists($path) ? $path : base_url($default);
}

/**
 * Convert ke angka Romawi
 * @param integer $integer
 * @return string
 */
function convertToRoman($integer)
{
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array('M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1);

    foreach($lookup as $roman => $value){
        // Determine the number of matches
        $matches = intval($integer/$value);

        // Add the same number of characters to the string
        $result .= str_repeat($roman,$matches);

        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}


/**
 * Convert ke fromat tanggal indonesia
 * @param string $tanggal
 * @param bool $days
 *
 * @return string
 */
function tglIndo($tanggal, $days = false){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    $hari = array ( 1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    // Misal hari ini adalah sabtu
    $num =  date('N', strtotime($tanggal)); // Hasil 6

    return (($days == true) ? $hari[$num]. ', ' : '') .$pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function bulan($bln){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    return ($bln != 0 ) ? $bulan[$bln] : "N/A";
}

/**
 * Number fromat dalam Rupiah
 * @param integer $rp
 * @return string
 */
function rp($rp){

    return ($rp != "") ? "Rp ". number_format($rp, 2, ",", ".") : "-";
}
/**
 * Mengambil deksripsi jenis kelamin L/P
 * @param string jk
 * @return string
 */
function jenikelamin($jk="Jenis Kelamin"){
    if(strtoupper($jk) == 'L')
        return "Laki-laki";
    elseif (strtoupper($jk) == 'P')
        return "Perempuan";
    else
        return "Tidak Diketahui";
}

/**
 * Mengambil keterangan agama dari inisial
 * @param string $a Inisial Agama
 * @return string
 * */
function agama($a="agama"){
    $arr = array('I'=>'Islam', 'K'=>'Katholik',
        'P'=>'Kristen', 'B'=>'Budha', 'H'=> 'Hindu',
        'L'=>'Lainnya'
    );
    if(array_key_exists($a, $arr)){
        return $arr[$a];
    }else{
        return "";
    }
}


function mainbase_url($uri = ''){
    $main = get_instance()->config->item('main_url');
    return $main.$uri;
}

function mainsite_url($uri = ''){
    $url_suffix = get_instance()->config->item('url_suffix');
    $main = get_instance()->config->item('main_url');
    return $main.$uri.$url_suffix;
}