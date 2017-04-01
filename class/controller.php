<?php
session_start();
ob_start();

require('../class/pkr.config.php');
require('../class/model.php');

/**
 * Controller Class 
 * Created by Francesco Li Volsi DONATE svinci@virtuasport.it !
 *
 * Class Controller extends MObserver
 * 
 */
class Controller {

    var $view;
    var $model;
    var $table;
    var $server;
    var $classname = "CONTROLLER";
    var $act_value;
    var $sub_act_value;

    /**
     * Contructor
     * 
     * Init Model and View
     */
    function Controller() {
        //Create Model
        $this->model = new Model();
        $this->act_value = isset($_REQUEST['act_value']) ? $_REQUEST['act_value'] : "";
        $this->sub_act_value = isset($_REQUEST['sub_act_value']) ? $_REQUEST['sub_act_value'] : "";

        if (($this->act_value == PKR_WWW) ||
                ($this->act_value == PKR_EXT_WWW) ||
                ($this->act_value == PKR_ADMIN)) {
            require('../class/view.php');
            //Create View
            $this->view = new View($this->model);
        }
    }

    /**
     * Run
     * 
     * Start Point of application MVC
     * Init Db and Logger
     */
    function Run() {
        if ((isset($_REQUEST['curr_table'])) && ($_REQUEST['curr_player'] > 0)) {
            Logger::setFileLog("../log/log_tbl_" . $_REQUEST['curr_table'] . "_" . date("dmy") . ".log");
            $GLOBALS['mylog'] = Logger::getInstance();
        }

        //Connect
        $this->model->Db();

        $this->Core($this->act_value, $this->sub_act_value);

        //Disconnect
        $this->model->disconnect();

        if ((isset($_REQUEST['curr_table'])) && ($_REQUEST['curr_player'] > 0)) {
            $GLOBALS['mylog']->close();
            unset($GLOBALS['mylog']);
        }

        ob_end_flush();
    }

    /**
     * Core
     * 
     * Set all cases of application
     * @param string $act_value
     * @param string $sub_act_value
     */
    function Core($act_value, $sub_act_value = "") {
        if (($act_value != PKR_WWW) &&
                ($act_value != PKR_EXT_WWW) &&
                ($act_value != PKR_ADMIN) &&
                (!isset($_REQUEST['curr_table']))
        ) {
            ?>
            <html>
                <head>
                    <title><?php echo PKR_SITE_TITLE ?></title>
                </head>
                <body onLoad="document.forms['gogame'].submit();">
                    <form action="<?php $_SERVER['SCRIPT_NAME'] ?>" name="gogame" method="POST">
                        <input type="hidden" name="act_value" value="pkr_www">
                        <input type="hidden" name="sub_act_value" value="pkr_home">
                    </form>
                </body>
            </html>			
            <?php
            exit();
        }

        // Risparmio tempo...
        if (
                ($act_value != PKR_WWW) &&
                ($act_value != PKR_EXT_WWW) &&
                ($act_value != PKR_ADMIN)
        ) {
            require("../class/pkr.table.class.php");
            $this->table = new Table($_REQUEST['curr_player'], $_REQUEST['curr_table']);
        }

        switch ($act_value) {
            case PKR_ADMIN:

                switch ($sub_act_value) {
                    case PKR_MAIN_MENU:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->topAdmin();
                        $this->view->mainMenu();

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_MANAGE_PLAYERS:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->topAdmin();
                        $this->view->managePlrs();

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_DEL_PLAYER:
                        $this->view->sHeader();
                        $this->model->deletePlr($_REQUEST['idplayer']);
                        $this->view->redirect();
                        $this->view->sFooter();
                        break;

                    case PKR_INIT_ALL:
                        $this->view->sHeader();

                        $truncate = false;
                        $optimize = false;
                        $upd_credit = false;

                        if ($_REQUEST['truncate'] == "si")
                            $truncate = true;

                        if ($_REQUEST['upd_credit'] == "si")
                            $upd_credit = true;

                        if ($_REQUEST['optimize'] == "si")
                            $optimize = true;

                        $GLOBALS['mydb']->initdb($truncate, $upd_credit, $optimize);
                        $this->view->redirect(PKR_MAIN_MENU);
                        $this->view->sFooter();
                        break;

                    case PKR_RESET_ALL:
                        $this->view->sHeader();
                        $GLOBALS['mydb']->resetdb($GLOBALS['bonus']);
                        $this->view->redirect(PKR_MAIN_MENU, 5);
                        $this->view->sFooter();
                        break;

                    case PKR_NEWSLETTER:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        switch ($_REQUEST['sub_sub_act_value']) {
                            case PKR_SEND_NEWSLETTER:
                                $bcc = $this->model->toBcc();
                                if ($this->view->sendNewsletter($_REQUEST['subject'], $_REQUEST['body'], $bcc))
                                    $this->view->redirect(PKR_MAIN_MENU, 5);
                                else
                                    $this->view->back("ERROR TO SEND MAIL");
                                break;

                            case PKR_PREPARE_NEWSLETTER:
                            default:
                                $this->view->topAdmin();
                                $this->view->prepareNewsletter();
                                break;
                        }
                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_SHOW_LOGS:

                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->topAdmin();

                        switch ($_REQUEST['sub_sub_act_value']) {
                            case PKR_VIEW_LOG:
                                $this->view->viewLog($_REQUEST['file']);
                                break;

                            case PKR_DEL_LOG:
                                $this->model->del_file($_REQUEST['file']);
                                $this->view->redirect(PKR_SHOW_LOGS);
                                break;

                            default:
                                $arr = $this->model->dir_list(CONST_LOG_PATH);
                                $this->view->showFilesLog($arr);
                                break;
                        }

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_DEL_NOT_CONFIRMED_PLAYERS:
                        $this->view->sHeader();
                        $this->model->deleteNotConfirmedPlr();
                        $this->view->redirect();
                        $this->view->sFooter();
                        break;

                    case PKR_MOD_PLAYER:
                        switch ($_REQUEST['sub_sub_act_value']) {
                            case PKR_MOD:
                                $this->view->sHeader();
                                $this->model->modifyPlr($_REQUEST);
                                $this->view->redirect();
                                $this->view->sFooter();
                                break;

                            default:
                                $this->view->sHeader();
                                $this->view->globalHeader();

                                $this->view->topAdmin();
                                $this->view->inputModPlr($_REQUEST['idplayer']);

                                $this->view->globalFooter();
                                $this->view->sFooter();
                                break;
                        }
                        break;

                    case PKR_MANAGE_ROOMS:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->topAdmin();
                        $this->view->manageRooms();

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_DEL_ROOM:
                        $this->view->sHeader();
                        $this->model->deleteRoom($_REQUEST['idroom']);
                        $this->view->redirect(PKR_MANAGE_ROOMS);
                        $this->view->sFooter();
                        break;

                    case PKR_CREATEROOM:
                        if (!$this->model->createRoom($_POST))
                            $this->view->doAlert("\"Error. Retry insert\"");
                        $this->view->redirect(PKR_MANAGE_ROOMS, 1, true);
                        break;

                    case PKR_MANAGE_TABLES:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->topAdmin();
                        $this->view->manageTbls();

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_DEL_TABLE:
                        $this->view->sHeader();
                        $this->model->deleteTbl($_REQUEST['idtable']);
                        $this->view->redirect(PKR_MANAGE_TABLES);
                        $this->view->sFooter();
                        break;

                    case PKR_CREATETBL:
                        if (!$this->model->createTbl($_POST))
                            $this->view->doAlert("\"Error. Retry insert\"");
                        $this->view->redirect(PKR_MANAGE_TABLES, 1, true);
                        break;

                    case PKR_LOGIN:

                        switch ($_REQUEST['sub_sub_act_value']) {
                            case PKR_2LOGIN:
                                $this->view->sHeader();
                                $this->view->toAdminLogin();
                                $this->view->sFooter();
                                break;

                            default:
                                $this->view->sHeader();
                                $this->view->globalHeader();
                                $this->view->top();

                                $this->view->adminLogin();

                                $this->view->globalFooter();
                                $this->view->sFooter();
                                break;
                        }

                        break;

                    case PKR_CROPGAME:
                        echo "....";
                        if (is_numeric($_GET['g'])) {
                            echo "Crop game " . $_GET['g'];
                            $this->model->cropGame($_GET['g']);
                        }
                        break;
                }

                break;

            case PKR_GETDATALANGUAGES:
                $this->table->getDataLanguages();
                break;

            case PKR_REQTABLEPROPERTIES:
                $this->table->getTableProperties();
                break;

            case PKR_REQDATATABLE:
                //Securr chat msg
                $this->table->setCurrMsg($_REQUEST['curr_msg']);
                //Active server
                $this->table->changeSubHandSeat();
                //Get Data Engine Table 			
                $this->table->getDataTable();
                break;

            case PKR_RESPACTION:
                $this->table->getResponseSubHand($_REQUEST['user_response'], number_format($_REQUEST['curr_post'], 2, '.', ''), $_REQUEST['curr_seat'], null, false, $_REQUEST['ctg']);
                break;

            case PKR_REQCREDIT:
                $this->table->getCredit();
                break;

            case PKR_RESPCHATMSG:
                if (!empty($_REQUEST['user_chat_msg']) && !empty($_REQUEST['curr_player']))
                    $this->table->insChatMsg($_REQUEST['user_chat_msg'], MSG_FOR_CHAT, $_REQUEST['curr_player'], true);
                else {
                    $rows = array();
                    $rows['response'] = "OK";
                    if (DEBUG) {
                        echo "<pre>";
                        print_r($rows);
                        echo "</pre>";
                    } else
                        send_data($rows);
                    unset($rows);
                }
                break;

            case PKR_REQSEATOPEN:
                $this->table->insPlayerInTable($_REQUEST['curr_player'], $_REQUEST['curr_req_seat_number']);
                break;

            case PKR_SETSERVER:
                //USED ON LIST_TABLES.SWF
                $this->table->updateStatusTables();
                break;

            case PKR_REQPLRCREDIT:
                $this->table->getPlayerInfoCredit();
                break;

            case PKR_SETPLRTBLCREDIT:
                $this->table->setPlayerTableCash($_REQUEST['credit']);
                break;

            case PKR_REQSITTINGORIDLE:
                $this->table->setPlayerSwitchSitting_Idle($_REQUEST['curr_seat']);
                break;

            case PKR_REQLEAVESEAT:
                $this->table->setPlayerLeaveSeat($_REQUEST['curr_seat']);
                break;

            case PKR_REQTABLES:
                $idroom = (isset($_REQUEST['room'])) ? $_REQUEST['room'] : 0;
                $this->table->getListTables($idroom);
                break;

            // CHECK SESSION
            case PKR_REQDATAPLR:
                $rows = array();
                $rows['response'] = "OK";
                if (DEBUG) {
                    echo "<pre>";
                    print_r($rows);
                    echo "</pre>";
                } else
                    send_data($rows);
                unset($rows);
                break;

            case PKR_REQDATABOT:
                $noidplr = (isset($_REQUEST['noIdPlr'])) ? false : true;
                $this->table->getBotIdPlayer($noidplr);
                break;

            // EXT FUNCTIONS
            case PKR_EXT_WWW:
                require('../class/ext.controller.methods.php');
                break;

            default:
            case PKR_WWW:

                $idroom = (isset($_REQUEST['room'])) ? $_REQUEST['room'] : 0;

                switch ($sub_act_value) {
                    case PKR_SND_MAIL_PSWD:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->sendMail2ChangePswd();

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_CHANGE_PSWD:
                    case PKR_SET_NEW_PSWD:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->changePassword();

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_TABLE:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        $this->view->table($_REQUEST['isguest']);

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_CONFIRM:
                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top();

                        $this->view->checkConfirm($_REQUEST['usr'], $_REQUEST['mail'], $_REQUEST['code']);

                        $this->view->globalFooter();
                        $this->view->sFooter();
                        break;

                    case PKR_USRS_PROFILE:
                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, false);

                        $this->view->options($idroom);

                        $arr = $this->model->getPlayerDataProfile($_REQUEST['id']);
                        $this->view->viewUserProfile($arr);

                        $this->view->globalFooter(false, true);
                        $this->view->sFooter();
                        break;

                    case PKR_USR_PROFILE:

                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, false);

                        $this->view->options($idroom);

                        switch ($_REQUEST['sub_sub_act_value']) {

                            default:
                                if (isset($_SESSION['my_idp'])) {
                                    $arr = $this->model->getPlayerDataProfile($_SESSION['my_idp']);
                                    $this->view->viewPlayerProfile($arr);
                                } else {
                                    ?>		
                                    <br><br><br><br>
                                    <table cellspacing="0" width="900" cellpadding="0">
                                        <tr>
                                            <td width="100%" align="center"><b>&nbsp;&nbsp;SESSIONE&nbsp;SCADUTA&nbsp;&nbsp;</b><br><br>&nbsp;&nbsp;&nbsp;ASSICURATI&nbsp;DI&nbsp;AVERE&nbsp;I&nbsp;COOKIES&nbsp;ABILITATI&nbsp;&nbsp;&nbsp;<br><br><br><input type="button" value="<< ESCI" onClick="window.href = 'logout.php'">
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                break;
                        }

                        $this->view->globalFooter();
                        $this->view->sFooter();

                        break;

                    case PKR_LOGIN:

                        switch ($_REQUEST['sub_sub_act_value']) {
                            case PKR_3LOGIN:
                                $this->view->toLogin(false);
                                break;

                            case PKR_2LOGIN:
                                $this->view->toLogin();
                                break;

                            default:
                                $this->view->sHeader();
                                $this->view->globalHeader();
                                $this->view->top();

                                $this->view->login();

                                $this->view->globalFooter();
                                $this->view->sFooter();
                                break;
                        }

                        break;

                    case PKR_REGISTER:

                        switch ($_REQUEST['sub_sub_act_value']) {
                            case PKR_2REGISTER:
                                $this->view->toRegister();
                                break;

                            default:
                                $this->view->sHeader();
                                $this->view->globalHeader();
                                $this->view->top();

                                $this->view->register();

                                $this->view->globalFooter();
                                $this->view->sFooter();
                                break;
                        }

                        break;

                    case PKR_VIEWRANKING:

                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, true);

                        $this->view->options($idroom);
                        $this->view->viewRanking($_REQUEST['page']);

                        $this->view->globalFooter(false, true);
                        $this->view->sFooter();

                        break;

                    case PKR_VIEWGAMEHISTORY:
                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, true);

                        $this->view->options($idroom);
                        $this->view->getListGames($_REQUEST["game"]);

                        $this->view->globalFooter(false, true);
                        $this->view->sFooter();
                        break;

                    case PKR_VIEWRULES:
                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, true);

                        $this->view->options($idroom);
                        $this->view->getRules();

                        $this->view->globalFooter(false, true);
                        $this->view->sFooter();
                        break;

                    case PKR_VIEWYOURSITEPOKER:
                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, true);

                        $this->view->options($idroom);
                        $this->view->getPokerInYourSite();

                        $this->view->globalFooter(false, true);
                        $this->view->sFooter();
                        break;

                    case PKR_VIEWBUY:
                        $this->view->sHeader();
                        $this->view->globalHeader();
                        $this->view->top(true, true);

                        $this->view->options($idroom);
                        $this->view->getBuy();

                        $this->view->globalFooter(false, true);
                        $this->view->sFooter();
                        break;

                    default:
                    case PKR_HOME:
                        $this->view->sHeader();
                        $this->view->globalHeader();

                        //$this->view->HeaderTable();
                        //$this->view->openTD();						

                        $this->view->top(true, true);

                        $passRoom = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : null;

                        $this->view->options($idroom, true);
                        $this->view->body(false, $idroom, $passRoom);

                        //$this->view->closeTD();
                        //$this->view->donators();
                        //$this->view->FooterTable();

                        $this->view->globalFooter(true, true, true);
                        $this->view->sFooter();
                        break;
                }

                break;
        }

        if (($act_value != PKR_WWW) &&
                ($act_value != PKR_EXT_WWW) &&
                ($act_value != PKR_ADMIN)
        ) {
            $this->table->destroy();
        }
    }

}
?>
