<?php

    /*
    *  Copyright (c) Codiad & daeks & Coulee Techlink, distributed
    *  as-is and without warranty under the MIT License. See 
    *  [root]/license.txt for more. This information must remain intact.
    */
    
require_once('../../common.php');

class Svn extends Common {
  
    //////////////////////////////////////////////////////////////////
    // PROPERTIES
    //////////////////////////////////////////////////////////////////
    public $name='';
    public $path         = '';
    public $svnrepo      = false;
    public $svnbranch    = '';
    public $command_exec = '';
    public  $username = ''; 
    public $password = '';
    public $nohup_log = 'nohup.log';
    //////////////////////////////////////////////////////////////////
    // METHODS
    //////////////////////////////////////////////////////////////////

    // -----------------------------||----------------------------- //

    //////////////////////////////////////////////////////////////////
    // Construct
    //////////////////////////////////////////////////////////////////

    public function __construct(){
    }
    
    //////////////////////////////////////////////////////////////////
    // Pull Repo
    //////////////////////////////////////////////////////////////////
    
    public function pull(){
        
                    $cli_params = array();
                    $cli_params[] = "--non-interactive";
                    if( $this->username != '' ){
                        $cli_params[] = "--username " . $this->username;
                    }
                    if( $this->password != ''){
                        //Need to clean up the password so it can be passed to the cli, If anyone find's or thinks of more let me know tholum@couleetechlink.com
                        $this->password = str_replace( array("*","^","&",'"') , array('\*','\^','\&','\"') , $this->password);
                        $cli_params[] = "--password " . $this->password;
                    }
                    
        
        
        
        if($this->svnrepo){
            if(!$this->isAbsPath($this->path)) {
                if(!file_exists(WORKSPACE . '/' . $this->path)) {
                    $this->command_exec = "cd " . WORKSPACE . " && svn co \"" . $this->svnrepo . "\" ".$this->path." " . implode(" " , $cli_params);
                } else {
                    die(formatJSEND("success",array("message"=>"Folder already exists")));
                }
            } else {
                if(!file_exists($this->path)) {
                    $this->command_exec = "cd " . WORKSPACE . " && svn co \"" . $this->svnrepo . "\" ".$this->path." " . implode(" " , $cli_params);
                } else {
                    die(formatJSEND("success",array("message"=>"Folder already exists")));
                }
            }
            
            if($this->newproject){
                $this->projects = getJSON('projects.php');
                $this->projects[] = array("name"=>$this->name,"path"=>$this->path);
                saveJSON('projects.php',$this->projects);
            }
            
            $this->ExecuteCMD();
            
            echo formatJSEND("success",array("message"=>"Repo cloned"));
        } else {
            echo formatJSEND("error",array("message"=>"No Repo specified"));
        }
    }
    
    //////////////////////////////////////////////////////////////////
    // Execute Command
    //////////////////////////////////////////////////////////////////
    
    /*
    * No Hup allows for background exicution of code and is default in most linux distro's
    * I was running into issue's of my svn checkout's taking longer then the code was allowed to exicute
    * So I added this, You can simply dissable this by setting ExecuteCMD( $run_nohup=true) to ExecuteCMD( $run_nohup=false)
    */
    public function nohup_command(){
        
        file_put_contents('/tmp/nohup_script.sh', $this->command_exec . "\nrm -f /tmp/nohup_script.sh");
        $this->cmd_orig =  $this->command_exec;
        $this->command_exec = "chmod +x /tmp/nohup_script.sh";
        $this->ExecuteCMD(false);
        $this->command_exec = "nohup /tmp/nohup_script.sh > /tmp/nohup.log &";
        $this->ExecuteCMD(false);
        
    }
    public function ExecuteCMD( $run_nohup=true){
        if( $run_nohup ){
            $this->nohup_command();
        }
        if(function_exists('system')){
            ob_start();
            system($this->command_exec);
            ob_end_clean();
        }
        //passthru
        else if(function_exists('passthru')){
            ob_start();
            passthru($this->command_exec);
            ob_end_clean();
        }
        //exec
        else if(function_exists('exec')){
            exec($this->command_exec , $this->output);
        }
        //shell_exec
        else if(function_exists('shell_exec')){
            shell_exec($this->command_exec);
        }
    }
   
}

?>
