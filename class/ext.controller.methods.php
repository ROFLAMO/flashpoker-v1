<?php
switch ($sub_act_value) {
    case PKR_PUBLIC_EXT_HOME:
        $this->view->sExtHeader();
        $this->view->extGlobalHeader();

        //$this->view->HeaderTable();
        //$this->view->openTD();						
        //$this->view->top(true,true);	
        //$passRoom = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : null;

        $this->view->extbody();

        //$this->view->closeTD();
        //$this->view->donators();
        //$this->view->FooterTable();

        $this->view->extGlobalFooter();
        $this->view->sExtFooter();
        break;

    case PKR_EXT_LOGIN:

        switch ($_REQUEST['sub_sub_act_value']) {
            case PKR_EXT_3LOGIN:
                $this->view->toExtLogin(false);
                break;

            case PKR_EXT_2LOGIN:
                $this->view->toExtLogin();
                break;

            default:
                $this->view->sExtHeader();
                $this->view->extGlobalHeader();
                $this->view->top();

                $this->view->extLogin();

                $this->view->extGlobalFooter();
                $this->view->sExtFooter();
                break;
        }

        break;

    case PKR_EXT_USR_PROFILE:

        $this->view->sExtHeader();
        $this->view->extGlobalHeader();

        switch ($_REQUEST['sub_sub_act_value']) {

            default:
                if (isset($_SESSION['my_idp'])) {
                    $arr = $this->model->getPlayerDataProfile($_SESSION['my_idp']);
                    $this->view->extViewPlayerProfile($arr);
                } else {
                    ?>		
                    <br><br><br><br>
                    <table cellspacing="0" width="900" cellpadding="0"><form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="retry" method="post">
                            <tr>
                                <td width="100%" align="center">
                                    <b>&nbsp;&nbsp;SESSIONE&nbsp;SCADUTA&nbsp;&nbsp;</b><br><br>
                                    &nbsp;&nbsp;&nbsp;ASSICURATI&nbsp;DI&nbsp;AVERE&nbsp;I&nbsp;COOKIES&nbsp;ABILITATI&nbsp;&nbsp;&nbsp;<br><br><br>
                                    <input type="hidden" name="act_value" value="<?php echo PKR_EXT_WWW ?>">
                                    <input type="hidden" name="sub_act_value" value="<?php echo PKR_PUBLIC_EXT_HOME ?>">
                                    <input type="hidden" name="room" value="1">
                                </td>
                            </tr></form>
                    </table>
                    <?php
                }
                break;
        }

        $this->view->extGlobalFooter();
        $this->view->sExtFooter();

        break;
}
?>