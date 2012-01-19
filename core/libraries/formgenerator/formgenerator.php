<?php
/**
 * @brief Form generator
 * @package Another Form Generator
 * @author Gergely "Garpeer" Aradszki | garpeer [ $ ] gmail [ , ] com
 * @version 0.7.15
 * @license GPLv3
 *
 * Thanks for highlawn for the suggestions and improvements!
 *
 * Copyright (C) 2010  Gergely Aradszki
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    For more info, see <http://www.gnu.org/licenses/>.
 *
 */
class Form {
/**
 * @brief form configuration
 */
    protected $config;
    /**
     * @brief form content container
     */
    protected $form;
    /**
     * @brief fields array
     */
    protected $fields=Array();
    /**
     * @brief sent data holder
     */
    protected $input;
    /**
     * @brief errors
     */
    protected $error;
    /**
     * @brief error content
     */
    protected $errorBox;
    /**
     * @brief protection field
     */
    protected $protectionField;
    /**
     * @brief validator object
     */
    protected $validator=null;
    /**
     * @brief saved input data
     */
    protected $validInput=false;
    /**     *
     * @brief have groups been defined
     */
    protected $has_groups=false;
    /**
     * @brief form constructor
     */
    public function __construct() {
    //config options        
        $this->config["title"]["type"]="str";
        $this->config["errorBox"]["type"]="str";
        $this->config["name"]["type"]="str";
        $this->config["action"]["type"]="str";
        $this->config["action"]["class"]="str";
        $this->config["method"]["type"]="enum";
        $this->config["validator"]["type"]="str";
        $this->config["validatorClass"]["type"]="str";
        $this->config["sanitize"]["type"]="bool";
        $this->config["submitMessage"]["type"]="str";
        $this->config["submitClass"]["type"]="str";
        $this->config["showDebug"]["type"]="bool";
        $this->config["linebreaks"]["type"]="str";
        $this->config["divs"]["type"]="bool";
        $this->config["showErrors"]["type"]="bool";
        $this->config["errorTitle"]["type"]="str";
        $this->config["errorLabel"]["type"]="str";
        $this->config["errorClass"]["type"]="str";
        $this->config["errorPosition"]["type"]="enum";
        $this->config["showAfterSuccess"]["type"]="bool";
        $this->config["cleanAfterSuccess"]["type"]="bool";
        $this->config["submitField"]["type"]="str";
        $this->config["class"]["type"]="str";
        $this->config["attributes"]["type"]="str";

        //config allowed values
        $this->config["method"]["allowed"]=Array("get", "post");
        $this->config["errorPosition"]["allowed"]=Array("before", "after", "in_before", "in_after");

        //config defaults
        
        $this->config["validator"]["value"]=dirname(__FILE__)."/validators.php";
        $this->config["validatorClass"]["value"]="Validator";
        $this->config["method"]["value"]="post";
        $this->config["sanitize"]["value"]=true;
        $this->config["errorBox"]["value"]="errorbox";
        $this->config["submitMessage"]["value"]="Form successfully submitted!";
        $this->config["submitClass"]["value"]="success";
        $this->config["errorPosition"]["value"]="in_before";
        $this->config["errorTitle"]["value"]="(!) Error:";
        $this->config["errorLabel"]["value"]="<span>(!)</span>";
        $this->config["errorClass"]["value"]="form-invalid";
        $this->config["linebreaks"]["value"]="<br />";
        $this->config["showErrors"]["value"]=true;
        $this->config["showDebug"]["value"]=false;
        $this->config["showAfterSuccess"]["value"]=true;
        $this->config["cleanAfterSuccess"]["value"]=true;
        $this->config["submitField"]["value"]="submit";
    }
    protected function getConfig($item) {
        if (isset($this->config[$item]["value"])) {
            return $this->config[$item]["value"];
        }
    }
    /**
     * @brief show debug information
     * @param $msg debug data
     */
    protected function debug($msg) {
        if ($this->getConfig("showDebug")) {
            echo "<code>(!)&nbsp;".$msg. "</code><br />\n";
        }
    }
    /**
     * @brief set config option
     * @param  $option option name
     * @param  $value option value
     *
     * possible values:
     * {option <type> explanation (default value)[optionlist]}
     *
     * title <str> title of the form
     * name <str> name & id of the form
     * action <str> action attr of form
     * method <enum> method attr of form (post) [get | post]
     * class <str> class attr of form
     * validator <str> filename of the validator class (validators.php)
     * validatorClass <str> name of the validator class (Validator)
     * sanitize <bool> sanitize input (true)
     * submitMessage <str> message displayed on successful submit (Form successfully submitted!)
     * submitField <str> id of submit button
     * showDebug <bool> show exception messages
     * linebreaks <str> what to use es linebreaks
     * divs <bool> use divs to encapsulate label&field rows
     * showErrors <bool> show validation error messages
     * errorTitle <str> title of the error list
     * errorLabel <str> prepends this to the label of the invalid field
     * errorPosition <enum> specify the position of the errorbox  [before | after | in_before | in_after]
     *        ("before" and "after" places the box outside the form element, the in_* parameters place it inside)
     * showAfterSuccess <bool> show form after succesful submit (true)
     * cleanAfterSuccess <bool> clean the fields after succesful submit (true)
     */
    public function set($option, $value) {
        try {
            if (isset($this->config[$option])) {
                switch($this->config[$option]["type"]) {
                    case "str":$this->config[$option]["value"]=$value;
                        break;
                    case "bool":$this->config[$option]["value"]=true&&$value;
                        break;
                    case "enum":
                        if (in_array($value, $this->config[$option]["allowed"])) {
                            $this->config[$option]["value"]=$value;
                        }else {
                            throw new Exception("Value &quot;".$value . "&quot; is not allowed for &quot;". $option."&quot;."  );
                        }
                        break;
                }
            }else {
                throw new Exception("&quot;" . $option . "&quot; is not an option."  );
            }
        }catch(Exception $e){
            $this->debug("Error in " . $this->getConfig("name") . " Form->set: " .$e->getMessage());
        }
    }
    /**
     * @brief saves input after successful validation
     */
    protected function saveValidInput() {
        $this->validInput=$this->input;
    }
    /**
     * @brief action on successful submit
     */
    protected function onSuccess() {
        if ($this->getConfig("submitMessage")!="") {
            return "<div class='".$this->getConfig("submitClass")."'>".$this->getConfig("submitMessage")."</div>";
        }
		return "";
    }
    /**
     * @brief load data from array
     * @param $data associative array of data
     * @param $map field id mapping array
     */
    public function loadData($data, $map=false){
        foreach ($data as $key => $value){
            if ($map){
               $this->input[$map[$key]]=$value;
            }else{
                $this->input[$key]=$value;
            }
        }        
    }

    /**
     * @brief add submit button & display form
     * @param  $label label of submit button
     * @param  $id name attribute of submit button
     */
    public function display($label=false, $id=false, $show = true) {
        if ($id){
            $this->config["submitField"]["value"]=$id;
        }
        $this->form ="<form action='". $this->getConfig("action") . "' method='".$this->getConfig("method") . "' ";
        if ($this->getConfig("name")) {
            $this->form.= " name='".$this->getConfig("name") . "' id='". $this->getConfig("name"). "' ";
        }
        if ($this->getConfig("enctype")) {
            $this->form.= " enctype='".$this->getConfig("enctype") . "'";
        }

            $this->form.= " class='formgen ".$this->getConfig("class") . "'";
			
			
            $this->form.= " ".$this->getConfig("attributes") . " ";
        
        $this->form.= " >\n";
        if ($this->getConfig("method")=="get") {
            $this->input=&$_GET;
        }else {
            $this->input=&$_POST;
        }
        foreach ($this->input as &$field) {
            $field=$this->sanitize($field);
        }
        if ($this->protectionField) {
            if (isset($this->input[$this->protectionField])) {
                $sent_code=$this->input[$this->protectionField];
            }else {
                $sent_code=false;
            }
            $this->validator( $this->protectionField, "jsProtector", $sent_code, $this->protectionCode);
        }
        $this->validateFields();        
        $this->writeErrors();
        if ($this->getConfig("title")) {
            $this->form .= "<fieldset><legend>" .$this->getConfig("title"). "</legend>";
        }
        if ($this->getConfig("errorPosition")=="in_before") {
            $this->form .= $this->errorBox;
        }
        if ((!isset($this->error))&&(isset($this->input[$this->getConfig("submitField")]))) {
            $this->saveValidInput();
              $this->form .= $this->onSuccess();
            if ($this->getConfig("cleanAfterSuccess")) {
                unset ($this->input);
                $this->input[$this->getConfig("submitField")]=true;
            }
        }
        if ((isset($this->error)) || ($this->getConfig("showAfterSuccess")) || (!isset($this->input[$this->getConfig("submitField")]))) {
            $this->groupClean();
            $this->createFields();
            if (isset($this->protectionCode)) {
                $this->form .= "<input type='hidden' name='".$this->protectionField."' id='".$this->protectionField."' value=''></input>";
                $this->form .= "<script type='text/javascript'>
				setTimeout(function(){
					document.getElementById('".$this->protectionField."').value='".$this->protectionCode . "';
				},3000);
				</script>";
            }
             if ($id){
                 $this->form.= "<div class='form-row'><input type='hidden' name='{$id}' value='{$label}' />
				 <input type='submit' value='{$label}'/></div>\n";
             }
            if ($this->getConfig("errorPosition")=="in_after") {
                $this->form .= $this->errorBox;
            }
            if ($this->getConfig("title")) {
                $this->form .= "</fieldset>";
            }
            $this->form.= "</form>\n";
			
            if ($this->getConfig("errorPosition")=="before") {
                $this->form = $this->errorBox .$this->form;
            }
       
            if ($this->getConfig("errorPosition")=="after") {
                $this->form .= $this->errorBox;
            }
			if( $show)
				echo $this->form;
			return $this->form;
        }
    }
    /**
     * @brief generate FormField
     * @param $type type (text|textarea|radio|checkbox|select|file|hidden|password|submit|reset|button|image)
     * @param $id id
     * @param $label label
     * @param <bool> $mandatory mandatory
     *@param $init_value initial value for fields. Its format depends on the field type
     * @param $aux additional attributes (eg. rows, cols, maxlength, options etc.)
     *
     * For radiobuttons, checkbox list and optionsets, an associative array must be given as the $aux parameter ( name => value). This array will be used to generate the list.
     */
    public function addField($type, $id,$label,$mandatory, $init_value=false, $aux=false) {
        $allowed=Array("text", "textarea", "radio", "checkbox", "select", "file", "hidden", "password", "submit", "reset", "button","image");
        if ((!$init_value)&&(isset($this->input[$id]))){
            $init_value=$this->input[$id];
        }
        if (in_array($type, $allowed)) {
            $this->fields[$id]=Array("type" =>$type,"label" =>$label,"mandatory" =>$mandatory, "init_value" =>$init_value, "aux" =>$aux);
        }
        if($type=="file") {
            $this->config["enctype"]["value"]="multipart/form-data";
        }
    }
    /**
     * @brief wrapping function for adding buttons
     * @param $type type of button
     * @param $id id & name of button
     * @param $value text of button
     */
    public function button($type, $id, $value, $aux=false){
        $this->addField($type, $id, false, false, $value, $aux);
    }
    /**
     * @brief acceskey for field
     * @param $field field name
     * @param $key acceskey value
     *
     * IMHO using accesskeys are not recommended as they may interfere with browser/textreader/etc. functions
     */
    public function accesKey($field, $key) {
        $this->fields[$field]["acceskey"]=$key;
    }
    /**
     * @brief register validator function for field
     * @param $field fields id
     * @param $function name of validator function
     */
    public function validator($field, $function) {
        try {
            if ($this->validator===null) {
                $this->validator=false;
                if(($this->getConfig("validator"))&&(file_exists($this->getConfig("validator")))) {
                    include_once($this->getConfig("validator"));
                    if (class_exists($this->getConfig("validatorClass"))) {
                        $this->validator=new Validator();
                    }else {
                        throw new Exception("Validator class &quot;" .$this->getConfig("validatorClass"). "&quot; does not exists.");
                    }
                }else {
                    throw new Exception("File not found: &quot;".$this->getConfig("validatorClass"). "&quot;");
                }
            }
            if ((isset($function))&&(method_exists($this->validator, $function))) {
                $this->fields[$field]["validator"]=$function;
                $this->fields[$field]["args"]=func_get_args();
            }else {
                throw new Exception("Method &quot;".$function. "&quot; does not exists.");
            }
        }catch (Exception $e ){
            $this->debug("Error in " . $this->getConfig("name") . " Form->validator: " .$e->getMessage());
        }
    }
    /**
     * @brief add text to form
     * @param $txt text
     */
    public function addText($txt) {
        $this->fields[] =Array("type"=>"auxtext", "content"=>"<p>".$txt."</p>");
    }
    /**
     * @brief add custom item to form
     * @param $item item
     * @param $id id of item
    * @param $label label of item
     */
    public function addItem($item, $id=false, $label=false) {
        $tmpitem=Array("type"=>"auxitem", "content"=>$item, "label" => $label);
        if ($id){
            $this->fields[$id] =$tmpitem;
        }else{
            $this->fields[] =$tmpitem;
        }
    }
    /**
     * @brief sets JS form protection
     * @param $code protection code
     *
     * This method tries to prevent form submission by bots.
     * A little js line fills a hidden field with the given validation code,
     * and the class checks this code on submit. This prevents form
     * submission by bots not supporting JS, but could also prevent
     * legal submissions, when the user has disabled JS.
     */
    public function JSprotection($code, $field="prtcode") {
        if ($code) {
            $this->protectionCode="".$code;
            $this->protectionField=$field;
            $this->fields[$field]["label"]="JS Protection";
        }
    }
    /**
     *@brief get the errors array
     */
    public function getErrors() {
        return $this->error;
    }
    /**
     * @brief get the input data array
     */
    public function getData() {
        $values=$this->validInput;
        unset($values[$this->protectionField]);
        unset($values[$this->getConfig("submitField")]);
        return $values;
    }
    /**
     * @brief validate fields
     *
     * the validator method has to return false if the field is valid, else it should return the error message
     */
    protected function validateFields() {
        if ($this->fields) {
            foreach ($this->fields as $id =>$field) {
                if (isset($field["mandatory"])) {
                    $mandatory=$field["mandatory"];
                }else {
                    $mandatory=false;
                }
                if (isset($field["validator"])) {
                    $validatorFunc=$field["validator"];
                }else {
                    $validatorFunc=false;
                }
                if (isset($field["args"])) {
                    $args=$field["args"];
                }else {
                    $args=false;
                }
                if (isset($this->input[$this->getConfig("submitField")])) {
                    if ( (isset($this->input[$id])) &&  ($this->input[$id]==="") && ($mandatory) ) {
                        $this->error($id);
                    }
                    if ($validatorFunc) {
                        if (isset($this->input[$id])) {
                            $value=$this->input[$id];
                        }else {
                            $value=false;
                        }
                        $this->error($id, $this->validator->{$validatorFunc}($value, array_slice($args, 2)),$this->input);
                    }
                }
            }
        }
    }
    /**
     * @brief creates fields
     */
    protected function createFields() {
        if ($this->fields) {
            $props=Array("type", "label", "content", "acceskey", "mandatory", "init_value", "aux", "validator", "args", "grouped");
            foreach ($this->fields as $id =>$field) {
                foreach ($props as $prop) {
                    if (isset($field[$prop])) {
                        ${$prop}=$field[$prop];
                    }else {
                        ${$prop}=false;
                    }
                }
                if ($type) {
                    if (($type=="auxtext")||($type=="auxitem")) {
                        $this->form.= $content;
                    }else {
                        if (($this->getConfig("divs"))&&($type!="hidden")&&($grouped<=1)) {
                            $this->form.= "<div class='form-row ";
                            if (isset($this->error[$id])&&($this->error[$id])) {
                                $this->form .= $this->getConfig("errorClass");
                            }
                            $this->form .="'>";
                        }
                        if (($label)&&($type!="hidden")) {
                            $this->form.= "<label for='".$id."'";
                            if($acceskey) {
                                $this->form.=" acceskey='".$acceskey. "' ";
                            }
                            $this->form .=">";
                            if (isset($this->error[$id])&&($this->error[$id])) {
                                $this->form.= $this->getConfig("errorLabel");
                            }
                            $this->form.=$label;
                            if ($mandatory) { $this->form.= "*";}
                            $this->form.= ": </label>\n";
                        }
                        switch ($type) {
                            case "text": $this->textfield($id, $mandatory, $init_value, $aux);
                                break;
                            case "hidden": $this->hiddenfield($id, $mandatory, $init_value, $aux);
                                break;
                            case "password": $this->passwordfield($id, $mandatory, $init_value, $aux);
                                break;
                            case "file": $this->filefield($id, $mandatory, $aux);
                                break;
                            case "textarea": $this->textarea($id, $mandatory, $init_value, $aux);
                                break;
                            case "radio": $this->radiobuttons($id, $mandatory, $init_value, $aux);
                                break;
                            case "select": $this->selectfield($id, $mandatory, $init_value, $aux);
                                break;
                            case "checkbox": $this->checkbox($id, $mandatory, $init_value, $aux);
                                break;
                            default: $this->createButton($type, $id, $init_value, $aux);
                                   break;
                        }
                        if (($this->getConfig("divs"))&&($type!="hidden")&&((!$grouped)||($grouped==3))) {
                            $this->form.= "</div>";
                        }                        
                    }
                }
            }
        }
    }

    /**
     * @brief generate password field
     * @param $id id
     * @param <bool> $mandatory mandatory
     * @param <str> $init_value Initial value
     * @param $aux additional attributes (eg. maxlength)
     */
    protected function passwordfield($id,$mandatory, $init_value, $aux) {
        $this->form.= "<input type='password' id='".$id."' name='". $id. "' value='";
        if (isset($this->input[$id])) {
            $this->form.= $this->input[$id];
        } elseif($init_value) {
            $this->form.=$init_value;
        }        
        $this->form.= "' ". $aux . " />";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
             $this->form.=$this->getConfig("linebreaks");
        }
         $this->form.= "\n";
    }
    /**
     * @brief generate hidden field
     * @param $id id
     * @param <bool> $mandatory mandatory
     *@param <str> $init_value Initial value
     * @param $aux additional attributes (eg. maxlength)
     */
    protected function hiddenfield($id,$mandatory, $init_value, $aux) {
        $this->form.= "<input type='hidden' id='".$id."' name='". $id. "' value='";
        if (isset($this->input[$id])) {
            $this->form.= $this->input[$id];
        } elseif($init_value) {
            $this->form.=$init_value;
        }
        $this->form.= "' ". $aux . " />";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
            $this->form.= $this->getConfig("linebreaks");
        }
         $this->form.= "\n";
    }


    /**
     * @brief generate text field
     * @param $id id
     * @param <bool> $mandatory mandatory
     * @param <str> $init_value Initial value
     * @param $aux additional attributes (eg. maxlength)
     */
    protected function textfield($id,$mandatory, $init_value, $aux) {        
        $this->form.= "<input type='text' id='".$id."' name='". $id. "' ".($mandatory ? 'required="required"' : "")." value='";       
        if (isset($this->input[$id])) {
            $this->form.= $this->input[$id];
        } elseif($init_value) {
            $this->form.=$init_value;
        }
         $this->form.= "' ". $aux . " />";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
             $this->form.=$this->getConfig("linebreaks");
        }
         $this->form.= "\n";
    }
    /**
     * @brief generate file upload field
     * @param $id id
     * @param <bool> $mandatory mandatory
     * @param $aux additional attributes (eg. accept)
     */
    protected function filefield($id,$mandatory, $aux) {
        $this->form.= "<input type='file' id='".$id."' name='". $id. "' ". $aux . " />";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
             $this->form.=$this->getConfig("linebreaks");
        }
         $this->form.= "\n";
    }
    /**
     * @brief generate textarea
     * @param $id id
     * @param <bool> $mandatory mandatory
     * @param <str> $init_value Initial value
     * @param $aux additional attributes (eg. rows, cols etc.)
     */
    protected function textarea($id,$mandatory, $init_value, $aux) {
        $this->form.= "<textarea id='".$id."' name='". $id. "' ".($mandatory ? 'required="required"' : "")." ". $aux . ">";
        if (isset($this->input[$id])) {
            $this->form.= $this->input[$id];
        } elseif($init_value) {
            $this->form.=$init_value;
        }
        $this->form.= "</textarea>";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
             $this->form.=$this->getConfig("linebreaks");
        }
         $this->form.= "\n";
    }
    /**
     * @brief generate radiobuttons
     * @param $id id
     * @param <bool> $mandatory mandatory
     * @param <str> $init_value Initial value.
     * @param $options options array (name => value)
     */
    protected function radiobuttons($id,$mandatory, $init_value, &$options) {
        if (!$init_value) {
            $tmpOpt=array_values($options);
            $init_value=$tmpOpt[0];
        }
        $this->form.=$this->config["linebreaks"]["value"]. "\n";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
            $this->form.=$this->getConfig("linebreaks");
        }
        echo "\n";
        if ((isset($this->input[$id]))&&($this->input[$id]=="")&& ($mandatory)) {
            $this->input[$id]=$options[key($options)];
        }
        $i = 1;
        foreach($options as $key => $value) {
            $this->form.= "<label class='sublabel' for='" . $id. "_" .$i . "'><input type='radio' id = '" . $id. "_" .$i . "' name='".$id."' value='" . $value. "' ";
            if ((isset($this->input[$id]))&&(($this->input[$id]==$value))||( (!isset($this->input[$id]))&&($init_value==$value)) ) {
                $this->form.= "checked='checked' ";
            }
            $i++;
            $this->form.= " />". $key . "</label>";
            if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
                 $this->form.=$this->getConfig("linebreaks");
            }
             $this->form.= "\n";
        }
    }
    /**
     * @brief generate select field
     * @param $id id
     * @param <bool> $mandatory mandatory
     * @param <str> $init_value Initial value
     * @param $options options array (name => value)
     */
    protected function selectfield($id,$mandatory, $init_value, &$options) {
        $this->form.= "<select id='".$id."' name='". $id. "' >";        
        foreach($options as $key => $value) {
            $this->form.= "<option value='" . $value. "' ";
            if ( ((isset($this->input[$id]))&&($this->input[$id]==$value)) || (!(isset($this->input[$this->getConfig("submitField")]))&&($init_value==$value))) {
                $this->form.= "selected='selected' ";
            }
            $this->form.= " >". $key . "</option>\n";
        }
        $this->form.="</select>";
        if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
                 $this->form.=$this->getConfig("linebreaks");
            }
             $this->form.= "\n";
    }
    /**
     * @brief generate checkbox
     * @param $id id
     * @param $init_value boolean for a single field, comma separated values if an array was given for the $options parameter
     * @param <bool> $mandatory mandatory
     * @param $options options array (name => value)
     */
    protected function checkbox($id,$mandatory, $init_value, $options) {
        if (is_array($options)) {
            $init_value=explode(",", str_replace(" ", "", $init_value));
            $i = 0;
            foreach ($options as $key => $value) {
                $this->form.= "<label class='sublabel' for='" . $id."_" . $value. "'><input type='checkbox' id='".$id."_" . $value ."' name='". $id."_" . $value. "' ";
                if (((isset($this->input[$id."_". $value]))&&($this->input[$id."_". $value])) || ((!(isset($this->input[$this->getConfig("submitField")])))&&(in_array($value, $init_value)))) {
                    $this->form.= " checked='checked' ";
                }
                $this->form.= " />".$key. "</label>";
                if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
                 $this->form.=$this->getConfig("linebreaks");
            }
             $this->form.= "\n";
                $i++;
            }
        }else {
            $this->form.= "<label class='sublabel' for='" . $id. "'><input type='checkbox' id='".$id."' name='". $id. "' ";
            if (((isset($this->input[$id]))&&(($this->input[$id]==="1")||($this->input[$id]==="on")))||( (!isset($this->input[$this->getConfig("submitField")]))&&($init_value) )) {
                $this->form.= " checked='checked' ";
            }
            $this->form.= " />".$options. "</label>";
            if((!$this->fields[$id]["grouped"])||($this->fields[$id]["grouped"]==3)){
                 $this->form.=$this->getConfig("linebreaks");
            }
             $this->form.= "\n";
        }
    }
    protected function createButton($type, $id, $value,$aux){
        $allowed=Array("submit", "reset", "button", "image");
        if (in_array($type, $allowed)){
            if ($type=="submit" || "image"){
                $this->config["submitField"]["value"]=$id;
            }
            $this->form.="<input type='". $type . "' id='".$id . "' name='".$id . "' value='".$value . "' ". $aux. "></input>";
            $this->form.=$this->getConfig("linebreaks");
        }
    }
    /**
     * @brief sanitize input text
     *
     * @param $str text to clean
     * @return cleaned text
     */
    protected function sanitize($str) {
        if ($this->getConfig("sanitize")==true) {
            $str=htmlspecialchars($str,ENT_QUOTES,"utf-8");
            $str=stripslashes($str);
        }
        return $str;
    }
    /**
     * @brief set error message
     * @param $field field id
     * @param $msg error message
     */
    protected function error($field, $msg="empty") {        
        if ($msg!==false) {
            $this->error[$field]["msg"]=$this->fields[$field]["label"] .": ". $msg;
            $this->error[$field]["link"]=$field;
        }
    }
    /**
     * @brief display error list
     */
    protected function writeErrors() {
        if (($this->error)&&($this->config["showErrors"]["value"])) {
            $this->errorBox = "<div class='".$this->getConfig("errorBox")."'><h4>". $this->config["errorTitle"]["value"]."</h4>\n";
            $this->errorBox .= "<ul id='errorList'>\n";
            foreach ($this->error as $error) {
                $this->errorBox .= "<li><label for='".$error["link"]."'>".$error["msg"]."</label></li>\n";
            }
            $this->errorBox .= "</ul>
			
			<div style='clear:both'></div></div>\n";
        }
    }
    /**
     * @brief join selected fields
     * @param ids of fields to join
     */
    public function join(){
        $this->has_groups=true;
        $args=func_get_args();        
        foreach($args as $arg){
            $this->fields[$arg]["grouped"]=true;
        }        
    }
    /**
     * @brief cleans joined groups
     *
     * field['grouped']:   0: nogroup, 1:start, 2:middle, 3:end
     */
    protected function groupClean() {
        if ($this->has_groups) {
            $status=false;
            foreach ($this->fields as &$item) {
                if ($item["grouped"]>0) {
                    $item["grouped"]=1;
                }
                if (($item["grouped"]==1)&&($prev["grouped"])) {
                    $item["grouped"]=2;
                }
                if (($item["grouped"]==0)&&($prev["grouped"]>1)) {
                    $prev["grouped"]=3;
                }
                if (($item["grouped"]==0)&&($prev["grouped"]==1)) {
                    $prev["grouped"]=false;
                }
                $prev=&$item;
            }        
        }
    }
}
?>