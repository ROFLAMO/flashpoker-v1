<?php
require('../class/class.external.view.php');

/**
 * View Class 
 *
 * Class View
 * 
 */
class View extends ExternalView {

    var $dbprovider;
    var $classname = "VIEW";
    var $cost;
    var $bonus;
    static $__lang = array();

    static function setLang() {
//CHARSET
        self::$__lang["charset"] = "iso-8859-2"; //"UTF-8";
//VIEW PAGES
        self::$__lang["GAME"] = "GAME";
        self::$__lang["TABLE"] = "TABLE";
        self::$__lang["profile_button"] = "PROFIL";
        self::$__lang['pswd'] = "PASSWORD";
        self::$__lang["meta_description"] = "Flash poker on line free texas holdem";
        self::$__lang["meta_keywords"] = "poker online, poker on line, flashpoker, texas holdem poker";
        self::$__lang["donators_text"] = "<font size=\"1\"><b>THANKS TO ALL<br>FLASHPOKER SUPPORTER:</b></font>";
        self::$__lang['tks_supporter'] = "<font size=\"2\"><b><u>Thanks to all supporters ! :)</u></b></font>";
        self::$__lang['download_flashplayer'] = "<a href=\"http://www.adobe.com/pl/products/flashplayer/\" target=\"_blank\"><u>download last flash player</u></a>";
        self::$__lang['footer_copyright'] = "<a href=\"http://www.flashpoker\" title=\"poker online\"><font color=\"white\"><b><u>www.flashpoker</u></b></font></a> Free Texas holdem & 5 Card Draw Poker [<b>NO REAL MONEY</b>] <a href=\"../index/admin.php\"><font color=\"white\"></font></a><b></b>.";
        self::$__lang['footer_network'] = "";
        self::$__lang['top_logo_description'] = "Free Texas Holdem Poker";
        self::$__lang['enter_room'] = "ENTER THE ROOM   ";
        self::$__lang['main_room'] = "Main Room";
        self::$__lang['public_room'] = "[Public Room]";
        self::$__lang['private_room'] = "[Private Room]";
        self::$__lang["wait_text"] = "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>...WAIT PLEASE...</b></font></div>";
        self::$__lang["login_error"] = "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>ERROR USER OR PASSWORD</b></font></div>";
        self::$__lang["footer_powered_by"] = '';
        self::$__lang["logged_as"] = "LOGGED AS;";
        self::$__lang["register"] = "<b><u>REGISTER</u></b>";
        self::$__lang["private_room_warning_text"] = "<blink><b>! WARNING !</b></blink><br><br>THIS IS A <b>PRIVATE ROOM</b><br><br>PLEASE INSERT PASSWORD TO ENTER";
        self::$__lang["game_text1"] = "<b>WELCOME</b> TO FLASH POKER ONLINE, PLAY IS EASY:</br><b>REGISTER</b>, <b>LOGIN</b> AND <b>PLAY</b> POKER ONLINE TEXAS HOLDEM POKER O 5 CARDS DRAW FOR FREE";
        self::$__lang["game_text2"] = "<b></b> </br><b></b><b></b> <b></b> ";
        self::$__lang["login_warn1"] = "<b>SESSION ERROR</b><br><br>ENABLE COOKIES";
//COMMON BUTTON
        self::$__lang["enter_button"] = "ENTER";
        self::$__lang["close_button"] = "CLOSE";
        self::$__lang["retry_button"] = "RETRY";
        self::$__lang["confirm_button"] = "CONFIRM";
        self::$__lang["exit_button"] = "EXIT";
        self::$__lang["login_button"] = "LOGIN";
        self::$__lang['back_button'] = "<< BACK";
        self::$__lang["create_button"] = "CREATE";
        self::$__lang["logout_button"] = "LOGOUT";
        self::$__lang["modify_button"] = "MODIFY";
// REGISTRATION
        self::$__lang["register_top"] = '<b><font face="verdana,arial" size="3">REGISTER</font></b>';
        self::$__lang["register_bottom"] = '<b>*Field mandatory</b><br><br><b>Account not used for more then <?php echo PKR_TIME_TO_DELETE_ACCOUNT." giorni"?> not supporter will be deleted.</b>';
        self::$__lang["register_close_button"] = 'CLOSE';
        self::$__lang["register_send_button"] = 'REGISTER';
// REGISTRATION CONFIRMATION
        self::$__lang["registered_title"] = "Registration";
        self::$__lang["registered_text"] = '<center><b>SEE YOUR MAIL ADDRESS TO CONFIRM REGISTRATION<br><br></b></center>';
        self::$__lang["registered_close_button"] = ">> CLOSE <<";
        self::$__lang["registered_error"] = "<b>ERROR!<br>USER/MAIL EXISTS OR PSWD TOO SMALL<br></b>";
        self::$__lang["registered_retry_button"] = "<< RETRY";
        self::$__lang["registered_confirm_success"] = "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><center><b>REGISTRATION CONFIRMED ! THANKS..<br><br></b></center><br><br>";
        self::$__lang["registered_confirm_error"] = "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><center><b>ERROR TO CONFIRM REGISTATION..<br><br></b></center><br><br>";
        self::$__lang["registered_play_button"] = ">> PLAY POKER <<";
        self::$__lang["registered_exit_button"] = ">> GO HOME <<";
        self::$__lang["usr_not_confirmed"] = "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>USR NOT CONFIRMED</b></font></div>";
//ADMIN
        self::$__lang["manage_rooms"] = "MANAGE ROOMS";
        self::$__lang["manage_tables"] = "MANAGE TABLES";
        self::$__lang["manage_players"] = "MANAGE PLAYERS";
        self::$__lang["search_key_by"] = "&nbsp;SEARCH KEY BY <b>USR</b>/<b>MAIL</b>&nbsp;";
        self::$__lang["delete_players"] = "DELETE ALL NOT CONFIRMED PLAYERS";
        self::$__lang["initialize"] = "INITIALIZE";
        self::$__lang["truncate"] = "&nbsp;TRUNCATE&nbsp;";
        self::$__lang["delete_players"] = "DELETE ALL NOT CONFIRMED PLAYERS";
        self::$__lang["upd_credit_players"] = "&nbsp;UPDATE&nbsp;CREDITS&nbsp;";
        self::$__lang["optimize"] = "&nbsp;OPTIMIZE&nbsp;";
        self::$__lang["reset_all"] = "RESET ALL";
        self::$__lang["newsletter"] = "NEWSLETTER";
        self::$__lang["view_logs"] = "VIEW LOGS";
        self::$__lang["system_information_title"] = '<font size="2"><b>SYSTEM INFOMATION</b></font>';
        self::$__lang["paypal_account"] = "&nbsp;PAYPAL ACCOUNT:";
        self::$__lang["core_protocol"] = "&nbsp;CORE PROTOCOL:";
        self::$__lang["using_memcache"] = "&nbsp;USING MEMCACHE:";
        self::$__lang["using_remote_mail"] = "&nbsp;USING REMOTE MAIL:";
//RANK TABLE
        self::$__lang['n'] = "N";
        self::$__lang['usr'] = "USR";
        self::$__lang['rank'] = "RANK";
        self::$__lang['points'] = "POINTS";
        self::$__lang['credit'] = "CREDIT";
        self::$__lang['wins'] = "WINS";
        self::$__lang['got'] = "GOT";
//CHANGE PASSWORD
        self::$__lang['change_password'] = '<font size="2"><b>CHANGE PASSWORD</b></font>';
        self::$__lang['user'] = "USER";
        self::$__lang['mail'] = "MAIL";
        self::$__lang['send_mail_pass_button'] = "SEND MAIL TO CHANGE PASS";
        self::$__lang['mail_change_pass_obj'] = "Flashpoker.com change password";
        self::$__lang['mail_change_pass_text1'] = "To change password click here: ";
        self::$__lang['mail_sent_text'] = "Mail sent to your mail address: ";
        self::$__lang['mail_sent_error1_text'] = "<br><br><br><br><br>Error;<br><br><br><br><br><br><br>";
        self::$__lang['mail_sent_error2_text'] = "<br><br><br><br><br>&nbsp;User&nbsp;or&nbsp;Mail&nbsp;does&nbsp;not&nbsp;exists or&nbsp;Account&nbsp;not&nbsp;confirmed&nbsp;!&nbsp;<br><br><br><br><br><br>";
        self::$__lang['mail_change_pass_error1_text'] = '<font size="2"><b>PASSWORDS ARE NOT EQUALS !</b></font><br><br>';
        self::$__lang['new_passwd'] = 'NEW_PASSWD';
        self::$__lang['retype_new_passwd'] = 'RETYPE PASS';
//HISTORY PAGE
        self::$__lang['history'] = '<font size="2"><b>TABLE/GAMES HISTORY LIST:</b></font>';
        self::$__lang['generic_error'] = 'GENERIC ERROR!';
        self::$__lang['viewgame_button'] = 'VIEW GAME';
        self::$__lang['searchgame_button'] = 'SEARCH GAME';
        self::$__lang['history_board_cards'] = "<font size=\"2\"><b>BOARD CARDS</b></font>";
        self::$__lang['history_player_cards'] = "<font size=\"2\"><b>PLAYER CARDS (only no fold, winners)</b></font>";
        self::$__lang['history_hands'] = "<font size=\"2\"><b>HANDS</b></font>";
        self::$__lang['seat'] = "SEAT";
        self::$__lang['total'] = "TOTAL";
        self::$__lang['winners'] = "WINNERS";
        self::$__lang['no_winners'] = "<b>No Winners</b> caused by:<br>- Game end on Postblinds and <1 players.<br>- Bad client/server connection so money returned and game cancelled.";
        self::$__lang['opponent_fold'] = "opponent fold";
//RULES PAGE
        $__view_lan['texasholdem_rules'] = '<font size="2"><b>REGOLE TEXAS HOLDEM</b></font>
	<br>
	<br>
	<b>Tavoli e Giocatori</b>
	Sono presenti tavoli da 6 giocatori o da 10.
	<br>
	<br>
	<b>Dealer (Mazziere)</b>
	Il mazziere viene indicato con un grosso bottone (dealer button). Il giocatore di mazzo a fine mano passer� il bottone al giocatore alla sua sinistra.
	<br>
	<br>
	<b>Blind (Bui)</b>
	Ogni mano di Texas Hold�em inizia con 2 bui, il piccolo buio (small blind) e il grande buio (big blind) che dovranno essere coperti dai 2 giocatori alla sinistra del mazziere. I bui sono considerati come delle normali puntate e, se necessario, i giocatori che li hanno piazzati dovranno coprire solo la differenza fra i rispettivi bui e la puntata in corso. I giocatori che hanno coperto lo small blind e il big blind, quando � il loro turno, hanno la possibilit� di scegliere fra fold (abbandonare la mano), check (cip), call (vedere una puntata) e raise (rilanciare), cos� come ogni altro giocatore.
	<br>
	<br>
	<b>Distribuzione delle carte</b>
	A ciascun giocatore vengono distribuite 2 carte coperte, chiamate \'hole cards\'. Dopo un primo giro di puntate vengono messe sul tavolo 3 carte scoperte in comune per tutti, il flop; dopo un nuovo giro di puntate sar� messa sul tavolo una quarta carta comune, il turn, e dopo un altro giro di puntate sar� messa sul tavolo la quinta e ultima carta, il river. Si arriva cos� al giro di puntate finale.
	<br>
	<br>
	<b>Ordine delle puntate</b>
	Nel Texas Holdem ci sono 4 giri di puntate. Il primo giro di puntate parte dopo la distribuzione delle 2 carte iniziali. Il primo giocatore a parlare � quello a sinistra del big blind. Nei giri successivi il primo giocatore a parlare � quello alla sinistra del dealer.
	<br>
	<br>
	<b>Sviluppo</b>
	Dal secondo giro e fino alla fine della mano, il primo a giocare � il giocatore alla sinistra del dealer. Dopo il giro delle \'hole cards\', il dealer mette sul tavolo tre carte scoperte, comuni a tutti i giocatori (\'flop\'). Si punta e parte il terzo giro, col dealer che mette sul tavolo la quarta carta comune (denominata \'turn\' o \'fourth street\'). Si punta e parte il quarto giro: il dealer mette sul tavolo l� ultima carta comune (\'river\' o \'fifth street\').
	<br>
	<br>
	<b>Showdown e determinazione del vincitore</b>
	Dopo che si sono concluse tutte le puntate, si arriva allo showdown e alla determinazione del vincitore del piatto. Vince colui che ha realizzato il punto piu\' alto. Ognuno mostra le proprie carte coperte. La combinazione che vale al fine della determinazione del punto � la migliore che si pu� ottenere combinando le 2 carte coperte con le 5 carte comuni: un giocatore pu� utilizzare una, due o nessuna delle sue carte coperte. Se due o piu\' giocatori hanno lo stesso punto il piatto verr� equamente diviso tra questi.
	<br>
	<br>
	<br>
	Se ci sono state puntate dopo che è stato girato il river, sar� il giocatore che ha effettuato l�ultimo rilancio il primo a scoprire il suo punto. In caso contrario si partir� dal giocatore alla sinistra del dealer.
	<br>
	<br>
	<br>';

        $__view_lan['fivecards_rules'] = '<font size="2"><b>REGOLE 5 CARDS DRAW</b></font>
	<br>
	<br>
	Il 5 Card Draw poker è conosciuto semplicemente anche come �<b>Draw Poker</b>�.
	<br>
	<br>
	<b>Tavolo e giocatori</b> Le regole nel 5 Card Draw poker (molto simile al 7 Card Stud) consentono un numero di giocatori massimo pari a <b>sei</b> giocatori alla volta. Vi sono tuttavia poker rooms online che arrivano ad un limite di otto giocatori.
	<br>
	<br>
	<b>Dealer (Mazziere)</b> Come nelle altre varianti, nel 5 Card Draw  la D (�dealer button�) indica il dealer (mazziere). Il �dealer� si sposta in senso orario ad ogni mano.
	<br>
	<br>
	<b>Distribuzione delle carte</b> Prima che vengano distribuite le carte, i due giocatori alla sinistra del �dealer� fanno rispettivamente buio e contro-buio (�small blind� e �big blind�). I bui hanno lo scopo di dare inizio al gioco e la loro entit� dipende dai limiti del tavolo.
	<br>
	<br>
	<b>Ordine delle puntate</b> Ciascun giocatore riceve 5 carte coperte. Dopo che � stato completato il primo giro di puntate, ogni giocatore ha la possibilit� di cambiare da 0 a 5 carte. Per il cambio sono concessi solitamente 25 secondi (sempre nel caso del poker online). In caso di mancata azione in quest�arco di tempo il giocatore non potr� cambiare alcuna carta e non potr� puntare o rilanciare dopo che i cambi saranno stati completati. Per cambiare bisogna cliccare sulle carte che si desidera scartare e dunque sul bottone �CHANGE CARDS�.
	<br>
	<br>
	<b>Scarti</b> Le carte che si vuole cambiare sono quelle che si alzano dal mazzo. Se si cambia idea, sar� possibile ricliccare sulla carta e torner� tra le altre carte da gioco. Dopo aver selezionato tutte le carte che si vuole cambiare si pu� cliccare sul bottone \'CHANGE CARDS\'.
	<br>
	<br>
	<b>Sviluppo</b> Nel 5 Card Draw ci sono 2 giri di puntate. Il primo giro ha inizio dopo che ogni giocatore ha ricevuto le sue 5 carte. In tale giro il primo a puntare � il giocatore alla sinistra del controbuiante. Nel giro successivo, quello che avviene dopo il cambio delle carte, il primo a puntare � il primo giocatore ancora in gioco alla sinistra del dealer. Entrambi i giocatori, con o senza blind, hanno la possibilit� di rilanciare.
	<br>
	<br>
	<b>Showdown e determinazione del vincitore</b> Quando finiscono le puntate, si passa alla determinazione del vincitore del piatto. Vince il punto pi� alto utilizzando 5 carte. In caso di parit� il piatto si divide.
	<br>
	<br>
	<br>';
        self::$__lang['rules_points'] = '<font size="2"><b></b></font>';
        self::$__lang['rules_royal'] = "<b>Royal</b>";
        self::$__lang['rules_straight_flush'] = "<b>Straight Flush</b>";
        self::$__lang['rules_four_of_a_kind'] = "<b>Four of a King</b>";
        self::$__lang['rules_full_house'] = "<b>Full House</b>";
        self::$__lang['rules_flush'] = "<b>Flush</b>";
        self::$__lang['rules_straight'] = "<b>Straight</b>";
        self::$__lang['rules_three_of_a_kind'] = "<b>Three of a Kind</b>";
        self::$__lang['rules_two_pair'] = "<b>Two Pair</b>";
        self::$__lang['rules_one_pair'] = "<b>Pair</b>";
        self::$__lang['rules_high_card'] = "<b>High Card</b>";
        self::$__lang['rules_points_text'] = "";
        self::$__lang['rules_points_text2'] = "<div align=center><font size='2'><b> </b></font></div>";
        self::$__lang['login_error_wait'] = "<br><br><br><div align=\"center\"><font face=\"verdana,arial\" size=\"2\" face=\"verdana, arial\"><b>ERROR USER OR/AND PASSWORD<br>...PLEASE WAIT...</b></font></div>";
//NEWSLETTER
        self::$__lang['newsletter_title'] = "<font size=\"2\"><b>NEWSLETTER</b></font>";
        self::$__lang['newsletter_subject'] = "<b>Subject</b><br>";
        self::$__lang['newsletter_body'] = "<b>Body</b><br>";
//ADMINISTRATION AREA
        self::$__lang['admin_top_logo_description'] = "Free&nbsp;Texas&nbsp;Holdem&nbsp;Poker";
        self::$__lang['admin_title'] = "<br><br><br><br><br><br><br><br><center><b>ADMINISTRATION AREA</b></center><br>";
        self::$__lang['admin_title_2'] = "<font size=\"2\"><b>ADMINISTRATION AREA</b></font>";
        self::$__lang['admin_user'] = "USER";
        self::$__lang['admin_pass'] = "PASS";
//ADMIN MANAGES ROOMS,TABLES,PLAYERS
        self::$__lang['name'] = "NAME";
        self::$__lang['pass'] = "PASS";
        self::$__lang['type'] = "TYPE";
        self::$__lang['status'] = "STATUS";
        self::$__lang['act'] = "ACT";
        self::$__lang['room'] = "ROOM";
        self::$__lang['plrs'] = "PLRS";
        self::$__lang['smin'] = "S.MIN";
        self::$__lang['smax'] = "S.MAX";
        self::$__lang['limited'] = "LIMITED";
        self::$__lang['act'] = "ACT";
        self::$__lang['city'] = "CITY";
        self::$__lang['c'] = "C";
        self::$__lang['supp'] = "SUPP";
        self::$__lang['alert_delete_warning_text'] = "Are you sure to delete this object ?";
        self::$__lang['typegame'] = "TYPE GAME";
        self::$__lang['insert_new_room'] = '<div align="center"><font size="2"><b>INSERT NEW ROOM</b></font></div>';
        self::$__lang['public'] = 'Public';
        self::$__lang['private'] = 'Private';
        self::$__lang['open'] = 'open';
        self::$__lang['close'] = 'close';
        self::$__lang['insert_new_table'] = '<div align="center"><font size="2"><b>INSERT NEW TABLE</b></font></div>';
        self::$__lang['si'] = "si";
        self::$__lang['no'] = "no";
        self::$__lang['texas_holdem'] = "Texas Holdem";
        self::$__lang['five_cards_draw'] = "Five Cards Draw";
        self::$__lang['no_limit'] = "no Limit";
//PROFILE
        self::$__lang["profile_registered_text"] = "REGISTERED";
        self::$__lang["profile_rank_text"] = "REGISTERED";
        self::$__lang["profile_user_text"] = "USER";
        self::$__lang["profile_points_text"] = "POINTS";
        self::$__lang["profile_ranking_text"] = "RANKING";
        self::$__lang["profile_your_pocket"] = "YOUR POCKET";
        self::$__lang["profile_pocket"] = "POCKET";
        self::$__lang["profile_money_lost"] = "MONEY LOST";
        self::$__lang["profile_repay"] = "Pay off your debt";
        self::$__lang["loading"] = "loading...";
        self::$__lang["currency"] = PKR_CURRENCY_SYMBOL;
        self::$__lang["profile_repay_all"] = "RIPAGA TUTTO IL DEBITO, DONANDO ";
        self::$__lang["profile_repay_half"] = "RIPAGA META' DEBITO, DONANDO ";
        self::$__lang["bonus"] = "BONUS";
        self::$__lang["not_supporter"] = "<br>NON SEI SUPPORTER :( DIVENTA SUPPORTER: ";
        self::$__lang["current_supporter_level"] = "<br>CURRENT SUPPORTER LEVEL ";
        self::$__lang["donate"] = "DONATE";
        self::$__lang["curr"] = "CURR.";
        self::$__lang["profile_info_text"] = '<b>Clicca su un\'icona bonus e supporta flashpoker facendo la tua donazione !</b>
				<br>
				<br>
				Flashpoker ti regala dei crediti che ti permetteranno di scalare la classifica (<b>RANKING</b>) del sito !!
				<br>
				<br>
				Inoltre ad ogni reset della classifica e dei crediti ti verranno riconosciuti:
				<br>
				<br>
				- Il 10% del totale dei crediti che si hanno prima del reset
				<br>
				- I crediti bonus relativi all\'ultima donazione effettuata
				<br>
				<br>					
				La transazione avviene in tutta sicurezza tramite connessione sicura (<b>SSL</b>) sui server di <a href="http://www.paypal.pl" target=_blank><b><u>Paypal</u></b></a>.
				<br>
				<br>
				L\'accredito dei soldi � automatico e immediato all\'avvenuta donazione inoltre il tuo account non verr� mai cancellato anche dopo i 30 gg di inutilizzo.
				<br>
				<br>
				Per qualsiasi informazione contatta lo staff: <a href="mailto:admin@flashpoker"><b><u>admin@flashpoker</u></b></a>';




        self::$__lang["yourpoker_top"] = '<br><center><br><font size="2"><b>INSERT PUBLIC POKER TABLES ON YOUR SITE</b></font><br><font size="2"><b>INSERISCI IL POKER SUL TUO SITO</b></font><br><br><br><br><br><br><br><br><br><br><b>CUT&PASTE</b> CODE ON YOUR SITE HTML PAGE FOR 802x479 pixels<br><b>COPIA&INCOLLA</b> IL CODICE NEL TUA PAGINA HTML PER 802x479 pixels<br>';
        self::$__lang["yourpoker_bottom"] = '<br>>> <a href="../yourpoker/demo.htm"><u>SEE A DEMO</u></a> <<<br>>> <a href="../yourpoker/demo.htm"><u>VEDI UNA DEMO</u></a> <<</center><br><br><br><br><br><br><br><br><br><br>';

        self::$__lang["buy_text"] = '<br>
		<br>
		<font size="3"><b>Specifiche Flashpoker V1.8.4 XJMF</b></font>
		<br>
		<br>
		<br>
		<b>Introduzione</b>
		<br>
		Flashpoker � un browser game multiplayer di poker alla texana e 5 cards Draw (poker classico con 5 carte).
		<br>
		E\' completamente automatico, server-less e non � necessario scaricare nessun file sul proprio pc per poter giocare.
		<br>
		Infatti basta collegarsi, iscriversi, fare login e giocare.
		<br>
		<br>
		<b>Specifiche Tecniche:</b>
		<br>
		L\'applicativo si compone di un Client ed un Server.
		<br>
		Il server � sviluppato in PHP versione 4.6+ compatibile e sfrutta un database su MySql4+
		<br>
		Il Client � sviluppato in Flash Actionscript 2.0
		<br>
		E\' stato utilizzato lato server il modello OOP MVC (Model View Control) pattern matching.
		<br>
		E\' presente un\'area di <b>installazione Wizard</b> che permette di installare facilmente e velocemente l\'applicazione direttamente online.
		<br>
		E\' stata inoltre, sviluppata un\'area di amministrazione in cui � possible vedere lo stato del server, gestire:
		<br> 
		gli utenti, i tavoli, le stanze, ottimizzare il database, visualizzare il log, inviare newsletter e resettare il gioco.
		<br>
		<br>
		Ogni tavolo creato pu� avere 6, 8, 10 posti e regole di tipo Texas Holdem o 5 Cards Draw.
		<br>
		<br>
		<b>I requisiti minimi:</b>
		<br>
		Linux/Windows Server (IIS Apache)
		<br>
		Apache 2.0
		<br>
		PHP5
		<br>
		Mysql4+
		<br>
		Flash Action Script 2.0 
		<br>
		Memcached daemon (facoltativo)
		<br>
		<br>
		La banda dipende dal numero di utenti che si hanno contemporanemante.
		<br>
		<br>
		<b>Sistema di CACHE:</b>
		<br>
		Oltre ad un sistema di cache tramite l\'uso di sessioni, l\'applicativo usa <b>memcache</b> se � presente sul server configurabile durante l\'installazione.
		<br>
		<br>
		<b>PHP Settings:</b>
		<br>
		L\'applicativo server non necessita di settaggi php.ini particolari.
		<br>
		E\' infatti installabile anche su un server di hosting.
		<br>
		<br>
		<b>Gestione Errori e Protocollo Client/Server:</b>
		<br>
		Il protocollo di scambio dati Client/Server � XML che JSON opportunamente criptati.
		<br>
		Gli errori sul server sono gestiti da una funzione handler e i log vengono scritti per ogni mano su un file di log.
		<br>
		<br>
		<b>Ulteriori informazioni:</b>
		<br>
		Potrebbe essere introdotto l\'utilizzo del cron di sistema per il controllo della presenza degli utenti ma di default non � necessario.
		<br>
		<br>
		<b>Documentazione:</b>
		<br>
		Il codice sorgente del Server usa variabili, metodi e classi hanno una nomenclatura in inglese e sono corredati da una descrizione dettagliata in PHPDoc-style.
		<br>
		E\' presente infatti una documentazione delle API dell\'applicativo in formato PHPDoc.
		<br>
		Il Client � sviluppato in stile "dummy" MovieClips, quindi facilmente modificabile.
		<br>
		<br>
		<b>Il prezzo per una singola licenza pro comprende:</b>
		<br>
		- codice sorgente client .fla
		<br>
		- codice sorgente server (solo i file utili a modificare il sito esterno)
		<br>
		- docs di installazione
		<br>
		- wizard installazione
		<br>
		costo <b>750�*</b>
		<br>
		<br>
		<b>Il prezzo per licenza illimitata comprende:</b>
		<br>
		- codice sorgente client .fla
		<br>
		- codice sorgente server completo
		<br>
		- codice sorgente client bot
		<br>
		- docs API server
		<br>
		- supporto 1 mese tramite mail
		<br>
		- docs di installazione
		<br>
		- wizard installazione
		<br>
		costo <b>3500�*</b>
		<br>
		<br>
		<br>
		<b>Se sei interessato o desideri ulteriori infomazioni contattaci:
		<br>
		<br>
		info</b>
		<br>
		<br>
		<br>
		<br>
		<br>
		<b>SCREENSHOOT</b>
		<br>
		<img src="../images/screen2.jpg">
		<br>
		<br>
		<img src="../images/screen3.jpg">
		<br>
		<br>
		<br>
		<small>* iva non compresa</small>
		<br>';
        self::$__lang['folder'] = "PERDENTE";
        self::$__lang['lost'] = "SCARSO";
        self::$__lang['suckle'] = "POPPANTE";
        self::$__lang['greenhorn'] = "PIVELLO";
        self::$__lang['novice'] = "PRINCIPIANTE";
        self::$__lang['conjugation'] = "ESORDIENTE";
        self::$__lang['intermediate'] = "INTERMEDIO";
        self::$__lang['able'] = "ABILE";
        self::$__lang['veteran'] = "VETERANO";
        self::$__lang['expert'] = "ESPERTO";
        self::$__lang['killer'] = "KILLER";
        self::$__lang['champion'] = "CAMPIONE";
        self::$__lang['superhuman'] = "SOVRUMANO";
        self::$__lang['superman'] = "SUPERMAN";

        self::$__lang['registration_mail'] = "Welcome to %s ! \n\nThank you %s, your registration must be confirmed by click there: \n%s?act_value=%s&sub_act_value=%s&usr=%s&mail=%s&code=%s\n\nBecome supporter and get more from flashpoker. ! Click here:";
        self::$__lang['registration_mail_success'] = "Thank you %s, for your registration to %s, your mail is %s\n\nBecome supporter and get more from flashpoker ! Click here\n";

        self::$__lang['system_critical_error'] = "Critical Site Error";
    }

    /**
     * Constructor 
     *
     * Set Db provider
     */
    function View($anDBProvider) {
        //self::$__lang = $_SESSION["__view_lan"];
        self::setLang();

        $this->cost = $GLOBALS['cost'];
        $this->bonus = $GLOBALS['bonus'];
        $this->dbprovider = $anDBProvider;
    }

    /**
     * sHeader
     * 
     * sHeader function
     */
    function sHeader() {
        ?>
        <html>
            <head>
                <LINK REL="SHORTCUT ICON" HREF="../images/favicon.ico">
                <title><?php echo PKR_SITE_TITLE ?></title>
                <meta name="description" content="<?php echo self::$__lang["meta_description"] ?>">
                <META name="keywords" content= "<?php echo self::$__lang["meta_keywords"] ?>">
                <meta name="refresh" content="0">
                <meta name="robots" content="index,follow">
                <meta name="copyright" content="<?php echo SITE_NAME ?> (2001-2005) Boo23. Tutti i diritti sono riservati.">
                <meta name="author" content="Boo23 creations">
                <meta name="generator" content="Crimson Editor">
                <meta name="revisit-after" content="1">
                <LINK href="../includes/pkr.css" type="text/css" rel="stylesheet">
                <script language="javascript">
                    <!--
                var myWindow = null;

                    function setFocus()
                    {
                        //var isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;
                        //if (isIE)
                        if (!myWindow.focus)
                            myWindow.focus();
                    }

        <?php
        if (SECURITY) {
            ?>
                        function openWindow(url, w, h, x, y, resize, scroll, n)
                        {
                            /*var start = new Date(1971);
                             var end = new Date();
                             var difference = end.getTime() - start.getTime();*/

                            var str = "resizable=" + resize + ",location=0,status=0,scrollbars=" + scroll + ",width=" + w + ",height=" + h;
                            var t = (document.layers) ? ',screenX=' + x + ',screenY=' + y : ',left=' + x + ',top=' + y;
                            myWindow = window.open(url, n, str + t);
                            myWindow.focus();
                        }
            <?php
        } else {
            ?>
                        function openWindow(url, w, h, x, y, resize, scroll, n)
                        {
                            var start = new Date(1971);
                            var end = new Date();
                            var difference = end.getTime() - start.getTime();

                            var str = "resizable=" + resize + ",location=0,status=0,scrollbars=" + scroll + ",width=" + w + ",height=" + h;
                            var t = (document.layers) ? ',screenX=' + x + ',screenY=' + y : ',left=' + x + ',top=' + y;
                            myWindow = window.open(url, difference, str + t);
                            myWindow.focus();
                        }
            <?php
        }
        ?>

                    //go Table
                    function gotbl(idtbl, isguest)
                    {
                        var tbl_x_base = 920;
                        var tbl_y_base = 598;
                        if ((screen.width <= tbl_x_base) || (screen.height <= tbl_y_base)) {
                            tbl_x_base = 950;
                            tbl_y_base = 628;
                            myWindow = openWindow("<?php echo $_SERVER['SCRIPT_NAME'] ?>?act_value=<?php echo PKR_WWW ?>&sub_act_value=<?php echo PKR_TABLE ?>&t=" + idtbl + "&isguest=" + isguest, tbl_x_base, tbl_y_base, "20%", "20%", "1", "1", "Table" + idtbl);
                        }
                        else {
                            myWindow = openWindow("<?php echo $_SERVER['SCRIPT_NAME'] ?>?act_value=<?php echo PKR_WWW ?>&sub_act_value=<?php echo PKR_TABLE ?>&t=" + idtbl + "&isguest=" + isguest, tbl_x_base, tbl_y_base, "20%", "20%", "0", "0", "Table" + idtbl);
                        }
                    }

                    //Leave Table			
                    function leavetable()
                    {
                        window.close();
                    }

                    //go Table
                    function gotbl_curr_window(idtbl, idplr)
                    {
                        document.forms['gotbl'].elements['t'].value = idtbl;
                        document.forms['gotbl'].submit();
                    }

                    //Leave Table			
                    function leavetable_curr_window()
                    {
                        document.forms['gohome'].submit();
                    }

                    //snd mail to change pswd
                    function goChangePass()
                    {
                        openWindow("<?php echo $_SERVER['SCRIPT_NAME'] ?>?act_value=<?php echo PKR_WWW ?>&sub_act_value=<?php echo PKR_SND_MAIL_PSWD ?>", 290, 230, "40%", "40%", 0, 0, "changepass");
                            }

                            //See game history
                            function goGameHistory()
                            {
                                document.forms['refresh'].elements['sub_act_value'].value = '<?php echo PKR_VIEWGAMEHISTORY ?>';
                                document.forms['refresh'].submit();
                            }

                            //See game history
                            function goRules()
                            {
                                document.forms['refresh'].elements['sub_act_value'].value = '<?php echo PKR_VIEWRULES ?>';
                                document.forms['refresh'].submit();
                            }

                            //See game history
                            function goYourSitePoker()
                            {
                                document.forms['refresh'].elements['sub_act_value'].value = '<?php echo PKR_VIEWYOURSITEPOKER ?>';
                                document.forms['refresh'].submit();
                            }

                            //See game history
                            function goBuy()
                            {
                                document.forms['refresh'].elements['sub_act_value'].value = '<?php echo PKR_VIEWBUY ?>';
                                document.forms['refresh'].submit();
                            }

                            //Login
                            function goLogin()
                            {
                                openWindow("<?php echo $_SERVER['SCRIPT_NAME'] ?>?act_value=<?php echo PKR_WWW ?>&sub_act_value=<?php echo PKR_LOGIN ?>", 230, 230, "40%", "40%", 0, 0, "login");
                                    }

                                    //Register
                                    function goRegister()
                                    {
                                        openWindow("<?php echo $_SERVER['SCRIPT_NAME'] ?>?act_value=<?php echo PKR_WWW ?>&sub_act_value=<?php echo PKR_REGISTER ?>", 385, 453, "20%", "20%", 0, 0, "register");
                                            }

                                            //Logout
                                            function logout(ext)
                                            {
                                                if (ext)
                                                    window.location = ext;
                                                else
                                                    window.location = 'logout.php';
                                            }

                                            //Gorank
                                            function gornk()
                                            {
                                                document.forms['refresh'].elements['sub_act_value'].value = '<?php echo PKR_VIEWRANKING ?>';
                                                document.forms['refresh'].submit();
                                            }

                                            function gohm()
                                            {
                                                document.forms['refresh'].submit();
                                            }

                                            function getFlashMovieObject(movieName)
                                            {
                                                if (window.document[movieName])
                                                {
                                                    return window.document[movieName];
                                                }
                                                if (navigator.appName.indexOf("Microsoft Internet") == -1)
                                                {
                                                    if (document.embeds && document.embeds[movieName])
                                                        return document.embeds[movieName];
                                                }
                                                else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
                                                {
                                                    return document.getElementById(movieName);
                                                }
                                            }

                                            function setFocus()
                                            {
                                                window.focus();
                                                var flashui = document.getElementById('mymovie');
                                                if (flashui && flashui.focus)
                                                    flashui.focus();
                                            }

                                            function confirmSubmit(testo)
                                            {
                                                var agree = confirm(testo);
                                                if (agree)
                                                    return true;
                                                else
                                                    return false;
                                            }

                                            /*
                                             function checkCR(evt) 
                                             {
                                             var evt  = (evt) ? evt : ((event) ? event : null);
                                             var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                                             if ((evt.keyCode == 13) && (node.type=="text")) {
                                             if (this.form)
                                             return submit();
                                             }
                                             }
                                             document.onkeypress = checkCR;
                                             */


        -->
                </script>
                <script src="../includes/AC_RunActiveContent.js" type="text/javascript"></script>
                <script src="../includes/AC_ActiveX.js" type="text/javascript"></script>
            </head>
            <body bgcolor="#dddddd">
                <?php
            }

            /**
             * sFooter
             * 
             * sFooter function
             */
            function sFooter() {
                ?>
            </body>
        </html>
        <?php
    }

    /**
     * openTD
     * 
     * openTD function
     */
    function openTD() {
        ?>
        <td valign="top">
            <?php
        }

        /**
         * closeTD
         * 
         * closeTD function
         */
        function closeTD() {
            ?>
        </td>
        <?php
    }

    /**
     * HeaderTable
     * 
     * HeaderTable function
     */
    function HeaderTable() {
        ?>
        <table border="0">
            <tr>
                <?php
            }

            /**
             * FooterTable
             * 
             * FooterTable function
             */
            function FooterTable() {
                ?>
            </tr>
        </table>
        <?php
    }

    /**
     * donators
     * 
     * donators function
     */
    function donators() {
        ?>
        <td valign="top">

            <table cellpadding="2" cellspacing="2" border="0" height="100%" width="200">

                <tr><td bgcolor="#dddddd" align="center" style="border-width: 1px 1px 1px 1px;
                        border-spacing: 2px;
                        border-style: solid solid solid solid;
                        border-color: black black black black;
                        -moz-border-radius: 12px 12px 12px 12px;
                        background-color: #EEEEEE;">
                        <?php echo self::$__lang["donators_text"] ?>
                    </td></tr>

                <tr><td>
                        &nbsp;
                    </td></tr>

                <?php
                //$this->getLastDonors();
                ?>

            </table>

        </td>
        <?php
    }

    /**
     * getLastDonors
     * 
     * getLastDonors function
     */
    function getLastDonors() {
        ?>
        <tr><td valign="top">
                <iframe src ="../index/getdonors.php" frameborder="0" height="505" scrolling="auto" width="100%"></iframe>
            </td></tr>
        <?php
    }

    /**
     * getDonors
     * 
     * getDonors function
     */
    function getDonors() {
        /* $fc = file(FILE_DONORS);		
          $arr = array();
          $bns = array();
          foreach ($fc as $k => $v)
          {
          $ele = explode(",",$v);
          $name = trim($ele[0]);
          $value = $ele[1];

          if (!isset($arr[$name]))
          $arr[$name] = 0;

          $arr[$name]+=$value;
          $bns[$name]++;
          } */

        $query = "select usr,bonus from pkr_player where supporter>0";
        $arr = $GLOBALS['mydb']->select($query);

        $tot = count($arr);
        $cols = 3;
        $elementsxcols = round($tot / $cols);
        ?>
        <br>
        <br>
        <br>
        <table width="600" border="0" align="center" cellspacing="3" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;">
            <tr><td align="center"><?php echo self::$__lang['tks_supporter'] ?></td></tr>
            <tr><td>

                    <?php
                    if (is_array($arr)) {
                        ?>

                        <table align="center" border="0"><tr>

                                <?php
                                reset($arr);
                                for ($col = 0; $col < $cols; $col++) {
                                    if ($col == 0)
                                        echo "<td>";
                                    else {
                                        if ($col < $cols)
                                            echo "</td><td width=\"" . ceil(100 / $cols) . "%\" valign=\"top\">";
                                    }

                                    $r = 0;
                                    ?>
                                <table border="0" align="center">
                                    <?php
                                    while (true) {
                                        $val = $arr[key($arr)];

                                        if (!isset($val))
                                            break;
                                        if ($val['bonus'] > 0) {
                                            echo "<tr>\n";
                                            echo "<td width=\"1\"><img src=\"../images/bonus/" . $val['bonus'] . ".png\"></td>\n";
                                            echo "<td style=\"border-width: 0px 0px 1px 0px; border-style: ridge ridge dotted ridge; border-collapse: collapse; border-spacing: 2px;\"><b>" . $val['usr'] . "</b></td>\n";
                                            echo "<td>" . ($this->cost[$val['bonus']]) . "&nbsp;�</td>\n";
                                            echo "</tr>\n";
                                            $r++;
                                        }

                                        next($arr);
                                        if ($r > $elementsxcols)
                                            break;
                                    }
                                    ?>
                                </table>
                                <?php
                            }
                            ?>		

                </tr></table>

            <?php
        }
        ?>

        </td></tr>

        <tr><td colspan="3">&nbsp;</td></tr>

        <tr>

        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <td colspan="3" align="center">

                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_donations">
                    <input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT ?>">
                    <input type="hidden" name="item_name" value="Donations flashpoker">
                    <input type="hidden" name="item_number" value="d_flshpkr">
                    <input type="hidden" name="no_shipping" value="0">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="currency_code" value="EUR">
                    <input type="hidden" name="tax" value="0">
                    <input type="hidden" name="lc" value="IT">
                    <input type="hidden" name="bn" value="PP-DonationsBF">
                    <input type="image" src="../images/generic_donate.gif" border="0" name="submit" alt="Effettua i tuoi pagamenti con PayPal.  un sistema rapido, gratuito e sicuro.">
                    <img alt="" border="0" src="https://www.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
                </form>

            </td>
        </form>

        </tr>		

        </table>
        <br>
        <br>
        <?php
    }

    /**
     * globalHeader
     * 
     * globalHeader function
     */
    function globalHeader() {
        ?>
        <table bgcolor="#FFFFFF" border="0" align="center" cellspacing="0" cellpadding="0" width="1" height="99%">
            <tr>
                <td valign="top">

                    <table bgcolor="#FFFFFF" width="100%" cellspacing="0" cellpadding="0" align="center">

                        <tr>
                            <td width="1" height="3"><img src="../images/site/leftup.gif"></td>
                            <td background="../images/site/up.gif" height="3"></td>
                            <td width="1" height="3"><img src="../images/site/rightup.gif"></td>
                        </tr>

                        <tr>
                            <td background="../images/site/left.gif" width="3" height="3"></td>

                            <td valign="top">	

                                <?php
                            }

                            /**
                             * globalFooter
                             * 
                             * globalFooter function
                             * @param boolean $getdonors
                             * @param boolean $copyright
                             * @param boolean $stat
                             */
                            function globalFooter($getdonors = false, $copyright = false, $stat = false) {
                                //if ($getdonors)
                                //	$this->getDonors();

                                if ($copyright) {
                                    ?>

                                    <table cellspacing="2" align="center">

                                        <tr><td>

                                                <table align="center"><tr>
                                                        <td><?php echo self::$__lang['download_flashplayer'] ?></td>
                                                        <td><a href="http://www.adobe.com/it/products/flashplayer/" target="_blank"><img src="../images/flash.gif" align="bottom" border="0"></a></td>
                                                    </tr></table>		

                                            </td></tr>

                                        <tr><td align="center">

                                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
                                                    <tr>		
                                                        <td width="1"><img src="../images/site/tleft.gif" border="0"></td>			
                                                        <td style="height:8px; font-size: 10px; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x" align="center">	
                                                            <?php echo self::$__lang['footer_copyright'] ?>
                                                        </td>
                                                        <td width="1"><img src="../images/site/tright.gif" border="0"></td>			
                                                    </tr>
                                                </table>			

                                            </td></tr>

                                        <tr><td align="center">
                                                <?php echo self::$__lang["footer_network"] ?>
                                            </td></tr>

                                    </table>

                                    <?php
                                }
                                ?>

                                <?php
                                if ($stat) {
                                    //HITSTAT
                                }
                                ?>

                            </td>

                            <td background="../images/site/right.gif" width="3" height="3"></td>
                        </tr>	

                        <tr>
                            <td><img src="../images/site/leftdown.gif"></td>
                            <td background="../images/site/down.gif" height="3"></td>
                            <td><img src="../images/site/rightdown.gif"></td>
                        </tr>
                    </table>		

                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * top
     * 
     * top function
     * @param boolean $menu
     * @param boolean $priv_adv
     */
    function top($menu = false, $priv_adv = false) {
        ?>
        <table width="100%" cellspacing="2" cellpadding="0" align="center" border="0">
            <tr>

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="refresh" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_HOME ?>">
                <input type="hidden" name="page" value="">
                <td width="1">
                    <table width="1" cellspacing="2" cellpadding="0" align="center">
                        <tr><td align="center">
                                <img src="../images/site/logov.png" border="0">
                            </td></tr>
                        <tr><td align="center"><?php echo self::$__lang['top_logo_description'] ?></td></tr>			
                    </table>
                </td>
            </form>

            <td align="center" width="100%">

                <?php
                if ($priv_adv) {
                    ?>		

                    <table border="0" width="468">
                        <tr>

                            <!-- spinpalace banner e box scadenza 22 Gen 2009 -->
                            <td width="395" align="center">

                                <!-- banner -->

                            </td>

                        </tr>
                    </table>

                    <?php
                }
                ?>			

            </td>

            <td width="1" align="right" valign="top">
            <!--<img src="../images/site/fishs.gif" border="0">-->
            <!--<table border="0">
                    <tr>
                    <td><a href="index.php?lan=italian"><img src="../images/langs/ita.jpg" border="0"></a></td>
                    <td><a href="index.php?lan=english"><img src="../images/langs/gbr.jpg" border="0"></a></td>
                    <td><a href="index.php?lan=polish"><img src="../images/langs/pol.jpg" border="0"></a></td>
                    </tr>
                    </table>-->
            </td>

        </tr>
        </table>

        <?php
        if ($menu) {
            ?>		
            <table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center">
                        <script type="text/javascript">
                                                AC_FL_RunContent('codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0', 'width', '908', 'height', '35', 'src', 'menu'); //end AC code
                        </script><noscript><object id="mymovie" name="mymovie" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="930" height="35" align="middle">
                            <param name="allowScriptAccess" value="sameDomain" />
                            <param name="movie" value="menu.swf" />
                            <param name="quality" value="high" />
                            <param name="bgcolor" value="#ffffff" />
                            <embed name="mymovie" src="menu.swf" quality="high" bgcolor="#ffffff" width="930" height="35" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></EMBED>
                        </object></noscript>			
                    </td></tr></table>
            <?php
        }
        ?>
        <?php
    }

    /**
     * getUsersOnline
     * 
     * getUsersOnline function
     * @param boolean $onlycount
     */
    function getUsersOnline($onlycount = false) {
        if ($onlycount) {
            $query = "select count(*) as n from pkr_player where idplayer in (select idplayer from pkr_alive where alive >= DATE_SUB(NOW(),INTERVAL 30 SECOND))";
            //echo $query;
            $rows = $GLOBALS['mydb']->select($query);
            return $rows[0]['n'];
        } else {
            $query = "select usr from pkr_player where idplayer in (select idplayer from pkr_alive where alive >= DATE_SUB(NOW(),INTERVAL 30 SECOND))";
            //echo $query;
            $rows = $GLOBALS['mydb']->select($query);
            return $rows;
        }
    }

    /**
     * getRoom
     * 
     * getRoom function
     * @param int $idroom
     */
    function getRoom($idroom) {
        $query = "select * from pkr_room where idroom = " . $idroom;
        $rows = $GLOBALS['mydb']->select($query);
        $rows = $rows[0];
        return $rows;
    }

    /**
     * getRooms
     * 
     * getRooms function
     * @param int $curr_room
     */
    function getRooms($curr_room = 0) {
        $query = "select * from pkr_room where status=1";
        $rows = $GLOBALS['mydb']->select($query);
        if ($curr_room == 0)
            $selected = "selected";
        else
            $selected = "";
        ?>
        <table border="0"><tr style="height:8px; font-size: 10px; color: white">
                <td><?php echo self::$__lang["enter_room"] ?></td>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="changeTbl" method="GET">
                <td>
                    <select name="room" onChange="document.forms['changeTbl'].submit()">
                        <option value="0" <?php echo $selected ?>><?php echo self::$__lang["main_room"] ?></option>
                        <?php
                        foreach ($rows as $k => $v) {
                            if ($curr_room == $v['idroom'])
                                $selected = "selected";
                            else
                                $selected = "";

                            $type = ($v['type'] == 0) ? $__lang['public_room'] : $__lang['private_room'];
                            ?>
                            <option value="<?php echo $v['idroom'] ?>" <?php echo $selected ?>><?php echo $type . " " . $v['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>	
                </td>
                <td>
                    <input type="submit" value="<?php echo self::$__lang["enter_button"] ?>">
                </td>
            </form>
        </tr></table>
        <?php
    }

    /**
     * options
     * 
     * Select Room and set login
     * @param int $idroom
     */
    function options($idroom, $selroom = false) {
        ?>
        <table width="920" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
            <tr>		
                <td width="1"><img src="../images/site/tleft.gif" border="0"></td>	

                <?php if ($selroom) { ?>
                    <td width="50%" style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x" align="left">
                        <?php echo $this->getRooms($idroom) ?></td>
                <?php } ?>

                <td style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x" align="right">
                    <?php
                    if (isset($_SESSION['my_idp'])) {
                        ?>	
                        <table cellspacing="0" width="200">
                            <tr style="height:8px; font-size: 10px; color: white">
                                <td align="center"><?php echo self::$__lang['logged_as'] ?><b><?php echo strtoupper($_SESSION['my_usr']) ?></b>&nbsp;</td>

                            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                                <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                                <input type="hidden" name="sub_act_value" value="<?php echo PKR_USR_PROFILE ?>">
                                <td align="center"><input type="submit" value="<?php echo self::$__lang["profile_button"] ?>"></td>
                            </form>

                            <td align="center"><input type="button" onClick="logout()" value="<?php echo self::$__lang["logout_button"] ?>"></td>
                </tr>
            </table>
            <?php
        } else {
            ?>
            <table border="0" cellspacing="0" width="200">
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                    <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                    <input type="hidden" name="sub_act_value" value="<?php echo PKR_LOGIN ?>">
                    <input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_3LOGIN ?>">
                    <tr style="height:8px; font-size: 10px; color: white">
                        <td>
                            <?php echo self::$__lang['usr'] ?>
                        </td>

                        <td>
                            <input type="text" size="15" name="usr" maxlength="30">
                        </td>	

                        <td>
                            <?php echo self::$__lang['pswd'] ?>
                        </td>

                        <td>
                            <input type="password" size="15" name="pswd" maxlength="30">
                        </td>	

                        <td align="center">
                            <input type="submit" value="LOGIN">
                        </td>

                        <td><a href="javascript:goChangePass()"><img src="../images/changepswd.gif" border="0"></a></td>

                </form>

                <td colspan="6" align="center">
                    <a href="javascript:goRegister()" style="height:8px; font-size: 10px; color: white"><?php echo self::$__lang['register'] ?></a>
                </td></tr>				
            </table>
            <?php
        }
        ?>		
        </td>
        <td width="1"><img src="../images/site/tright.gif" border="0"></td>			
        </tr>
        </table>		
        <?php
    }

    /**
     * body
     * 
     * body function
     * @param boolean $flag
     * @param int $isroom
     * @param string $passRoom
     */
    function body($flag = false, $idroom, $passRoom) {
        $onlycount = true;
        ?>		
        <table align="center" width="930" cellspacing="0" cellpadding="3">		

                        <!--<tr>
                        <td>
                        <font size="1"><b>Users playing: </b>-->
            <?php
            /* if (is_array($usrs)) {
              foreach ($usrs as $k => $v)
              echo $v['usr']." ";
              }
              else
              echo $usrs; */
            ?>
            <!--</font>
            </td>
            </tr>
                            
            <tr><td align="center">		
                                    
            </td></tr>-->

            <?php
            $checked = (isset($_SESSION["ctbl_" . $idroom])) ? true : false;
            $curr_room = $this->getRoom($idroom);

            if (($idroom == $curr_room['idroom']) && ($passRoom == $curr_room['password'])) {
                $_SESSION["ctbl_" . $idroom] = true;
                $checked = true;
            }

            if (($curr_room['type'] == 1) && (!$checked)) {
                ?>
                <tr>
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="retry" method="post">
                    <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                    <input type="hidden" name="sub_act_value" value="<?php echo PKR_HOME ?>">
                    <input type="hidden" name="room" value="<?php echo $idroom ?>">
                    <td align="center">
                        <br><br><br><br><br><br>
                        <?php echo self::$__lang["private_room_warning_text"] ?>			
                        <br>
                        <br>
                        <input type="password" name="password" size="25">&nbsp;<input type="submit" value="<?php echo self::$__lang["enter_button"] ?>">
                        <br><br><br><br><br><br><br><br>
                    </td>
                </form>
            </tr>
            <?php
        } else {
            ?>
            <tr>		
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="gotbl" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_TABLE ?>">
                <input type="hidden" name="t" value="">
                <td width="930" align="center">	
                    <script type="text/javascript">
                        AC_FL_RunContent(
                                'codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0',
                                'width', '908',
                                'height', '341',
                                'src', 'list_tables?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&sess=<?php echo session_id() ?>&my_idp=<?php echo $_SESSION['my_idp'] ?>&room=<?php echo $idroom ?>',
                                'quality', 'high',
                                'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
                                'movie', 'list_tables?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&sess=<?php echo session_id() ?>&my_idp=<?php echo $_SESSION['my_idp'] ?>&room=<?php echo $idroom ?>'
                                ); //end AC code
                    </script><noscript><object id="mymovie" name="mymovie" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="930" height="341" align="middle">
                        <param name="allowScriptAccess" value="sameDomain" />
                        <param name="movie" value="list_tables.swf?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&sess=<?php echo session_id() ?>&my_idp=<?php echo $_SESSION['my_idp'] ?>&room=<?php echo $idroom ?>" />
                        <param name="quality" value="high" />
                        <param name="bgcolor" value="#ffffff" />
                        <embed name="mymovie" src="list_tables.swf?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&sess=<?php echo session_id() ?>&my_idp=<?php echo $_SESSION['my_idp'] ?>&room=<?php echo $idroom ?>" quality="high" bgcolor="#ffffff" width="930" height="341" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></EMBED>
                    </object></noscript>			
                </td>
            </form>
            </tr>
            <?php
        }
        ?>	

        <tr><td align="center">
                <?php echo self::$__lang['game_text1'] ?>
            </td></tr>

        <tr><td align="center">
                <?php echo self::$__lang['game_text2'] ?>
            </td></tr>

        </table>

        <?php
        if ($flag) {
            ?>
            </td>
            <?php
        }
    }

    /**
     * table
     * 
     * table function
     * @param boolean $isguest
     */
    function table($isguest) {
        if (isset($_SESSION['my_idp'])) {
            ?>		
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td width="1">
                        <script type="text/javascript">
                            AC_FL_RunContent('codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0', 'width', '900', 'height', '580', 'src', 'table?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>', 'quality', 'high', 'pluginspage', 'http://www.macromedia.com/go/getflashplayer', 'movie', 'table?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>'); //end AC code
                        </script><noscript><object id="mymovie" name="mymovie" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="900" height="580" align="middle">
                            <param name="movie" value="table.swf?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>" />
                            <param name="quality" value="high" />
                            <param name="bgcolor" value="#ffffff" />
                            <embed name="mymovie" src="table.swf?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>" quality="high" bgcolor="#ffffff" width="900" height="580" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></EMBED>
                        </object></noscript>
                    </td>
                </tr>
            </table>
            <?php
        } else {
            if ($isguest == 1) {
                $_SESSION['my_idp'] = 0;
                ?>
                <table cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="1">
                            <script type="text/javascript">
                                AC_FL_RunContent('codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0', 'width', '900', 'height', '580', 'src', 'table?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>', 'quality', 'high', 'pluginspage', 'http://www.macromedia.com/go/getflashplayer', 'movie', 'table?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>'); //end AC code
                            </script><noscript><object id="mymovie" name="mymovie" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="900" height="580" align="middle">
                                <param name="movie" value="table.swf?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>" />
                                <param name="quality" value="high" />
                                <param name="bgcolor" value="#ffffff" />
                                <embed name="mymovie" src="table.swf?protocol=<?php echo CORE_PROTOCOL ?>&_myurl=<?php echo _myurl ?>&my_idplayer=<?php echo $_SESSION['my_idp'] ?>&my_idtable=<?php echo $_REQUEST['t'] ?>" quality="high" bgcolor="#ffffff" width="900" height="580" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></EMBED>
                            </object></noscript>
                        </td>
                    </tr>
                </table>
                <?php
                session_destroy();
            } else {
                ?>		
                <table cellspacing="0" width="900" cellpadding="0">
                    <tr>
                        <td width="100%" align="center"><?php echo self::$__lang['login_warn1'] ?><br><br><br><input type="button" value="<?php echo self::$__lang['close_button'] ?>" onClick="window.close()">
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
    }

    /**
     * register
     * 
     * register function
     */
    function register() {
        global $arr_pkr_player_tbl;
        ?>
        <br>
        <table width="330" cellspacing="2">

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_REGISTER ?>">
                <input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_2REGISTER ?>">		

                <tr><td colspan="2" align="center">
                        <?php echo self::$__lang['register_top'] ?>
                    </td></tr>

                <tr><td colspan="2" align="center">
                        &nbsp;
                    </td></tr>					
                <?php
                foreach ($arr_pkr_player_tbl as $col => $size) {
                    if ($col == 'pswd') {
                        ?>
                        <tr>
                            <td><b><?php echo strtoupper(self::$__lang['pswd']) ?></b></td><td><input type="password" size="30" name="<?php echo $col ?>" maxlength="<?php echo $size ?>">*&nbsp;(<?php echo MIN_REGISTATION_CHAR ?>-<?php echo $size ?>&nbsp;chars)</td>
                        </tr>
                        <?php
                    } else if ($col == 'city') {
                        ?>
                        <tr>
                            <td><b><?php echo strtoupper(self::$__lang['city']) ?></b></td><td><input type="text" size="30" name="<?php echo $col ?>" maxlength="<?php echo $size ?>"></td>
                        </tr>
                        <?php
                    } else if ($col == 'mail') {
                        ?>
                        <tr>
                            <td><b><?php echo strtoupper(self::$__lang['mail']) ?></b></td><td><input type="text" size="30" name="<?php echo $col ?>" maxlength="<?php echo $size ?>"></td>
                        </tr>
                        <?php
                    } else if ($col == 'usr') {
                        ?>
                        <tr>
                            <td><b><?php echo strtoupper(self::$__lang['usr']) ?></b></td><td><input type="text" size="30" name="<?php echo $col ?>" maxlength="<?php echo $size ?>"></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td><b><?php echo strtoupper($col) ?></b></td><td><input type="text" size="30" name="<?php echo $col ?>" maxlength="<?php echo $size ?>">*&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr><td colspan="2" align="center">
                        &nbsp;
                    </td></tr>		

                <tr><td colspan="2" align="center">
                        <?php echo self::$__lang['register_bottom'] ?>
                    </td></tr>				

                <tr><td colspan="2" align="center">
                        &nbsp;
                    </td></tr>			

                <tr><td colspan="2" align="center">
                        <input type="submit" value="<?php echo self::$__lang['register_send_button'] ?>">&nbsp;<input type="button" value="<?php echo self::$__lang['register_close_button'] ?>" onClick="window.close()">
                    </td></tr>	

            </form>

        </table>
        <br><br><br>
        <?php
    }

    /**
     * goRegister
     * 
     * goRegister function
     * @param string $p_usr
     * @param string $p_pwd
     * @param string $p_mail
     * @param string $p_city
     * @param string $confirm_code
     */
    function goRegister($p_usr, $p_pswd, $p_mail, $p_city, $confirm_code) {

        if (
                (strlen($p_usr) < MIN_REGISTATION_CHAR) ||
                (strlen($p_pswd) < MIN_REGISTATION_CHAR) ||
                (strlen($p_mail) < MIN_REGISTATION_CHAR)
        ) {
            return false;
        } else {

            $usr = clean($p_usr);
            $pswd = md5($p_pswd);
            $mail = clean($p_mail);
            $city = clean(strtoupper($p_city));

            $query = "SELECT count(*) as n from pkr_player where usr='" . $usr . "' or mail='" . $mail . "' ";
            $res = $GLOBALS['mydb']->select($query);

            if ($res[0]['n'] == 0) {

                $query = "INSERT INTO pkr_player (usr, pswd, mail, city, bonus, isc_date, sess, ip, code, confirmed) VALUES ";
                $query .= "('" . $usr . "', 
							'" . $pswd . "', 
							'" . $mail . "', 
							'" . $city . "', 
							'0',
							'" . time() . "',
							'" . session_id() . "',
							'" . $_SERVER["REMOTE_ADDR"] . "',
							'" . $confirm_code . "',
							'1'		
							)";

                $GLOBALS['mydb']->insert($query);
                $this->deleteOldAccount();
                return true;
            } else
                return false;
        }
    }

    /**
     * deleteOldAccount
     * 
     * deleteOldAccount function
     */
    function deleteOldAccount() {
        // Cancella tutti i player non supporter che non entrano da 30 gg
        $query = "delete from pkr_player where supporter = 0 and isbot = 0 and lastenter < DATE_SUB(NOW(),INTERVAL " . PKR_TIME_TO_DELETE_ACCOUNT . " DAY)";
        $GLOBALS['mydb']->delete($query);

        // Cancella da alive i record relativi a tutti i player non supporter che non entrano da 30 gg
        $query = "delete from pkr_alive where idplayer not in (select idplayer from pkr_player)";
        $GLOBALS['mydb']->delete($query);

        $GLOBALS['mydb']->optimize("pkr_player");
        $GLOBALS['mydb']->optimize("pkr_alive");
    }

    /**
     * sendMail
     * 
     * sendMail function
     * @param string $destinatario
     * @param string $mittente
     * @param string $oggetto
     * @param string $messaggio
     */
    function sendMail($destinatario, $mittente, $oggetto, $messaggio) {
        if (USE_REMOTE_SENDMAIL) {
            $url = "?to=" . urlencode($destinatario) . "&subj=" . urlencode($oggetto) . "&msg=" . urlencode($messaggio) . "&from=" . urlencode($mittente);
            $url = URL_SENDMAIL . $url;
            $res = file_get_contents($url);
            return (trim($res) == 'OK') ? true : false;
        } else {
            if (!mail($destinatario, $oggetto, $messaggio, "From: " . $mittente))
                return ERROR_TO_SEND_MAIL;
            else
                return true;
        }
    }

    /**
     * toRegister
     * 
     * toRegister function
     */
    function toRegister() {
        $confirm_code = md5(time());

        $res = $this->goRegister($_REQUEST['usr'], $_REQUEST['pswd'], $_REQUEST['mail'], $_REQUEST['city'], $confirm_code);

        if ($res)
            $this->sendMail($_REQUEST['mail'], CONST_ADMIN_MAIL, SITE_NAME . " potwierdzenie rejestracij", getMsgRegister($_REQUEST['usr'], $_REQUEST['mail'], $confirm_code));

        if ($res) {
            ?>
            <html><head><title><?php echo self::$__lang['registered_title'] ?></title><style>body{font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;}</style></head><body>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    <?php echo self::$__lang['registered_text'] ?>
                    <br>
                    <br>
                <center><input type="button" onClick="window.close()" value="<?php echo self::$__lang['registered_close_button'] ?>" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;"></center>
                <?php
            } else {
                ?>
                <html><head><title><?php echo self::$__lang['registered_title'] ?></title></head><body>
                        <br><br><br><br><br><br><br><br>
                        <table align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;">
                            <tr>
                                <td>
                                    <?php echo self::$__lang['registered_error'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <input type="button" onClick="history.back()" value="<?php echo self::$__lang['registered_retry_button'] ?>" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;">
                                </td>
                            </tr>
                        </table>
                    </body></html>
                <?php
            }
        }

        /**
         * confirm
         * 
         * confirm function
         * @param string $usr
         * @param string $mail
         * @param boolean $confirm_code
         */
        function confirm($usr, $mail, $confirm_code) {
            $myusr = clean($usr);
            $mymail = clean($mail);

            $query = "select * from pkr_player where usr='" . $myusr . "' and mail='" . $mymail . "' and code='" . $confirm_code . "'";
            $res = $GLOBALS['mydb']->select($query);

            if (isset($res)) {
                $idplayer = $res[0]["idplayer"];
                $confirmed = $res[0]["confirmed"];
            } else
                return false;

            if ($confirmed == 0) {
                $query = "update pkr_player set confirmed = ? where idplayer = ? ";
                $params = array(1, $idplayer);
                $GLOBALS['mydb']->update($query, $params);

                $this->sendMail($mail, CONST_ADMIN_MAIL, SITE_NAME . " registration confirmed", getMsgConfirm($usr, $mail));
            }

            return true;
        }

        /**
         * checkConfirm
         * 
         * checkConfirm function
         * @param string $usr
         * @param string $mail
         * @param boolean $confirm_code
         */
        function checkConfirm($usr, $mail, $confirm_code) {
            if ($this->confirm($usr, $mail, $confirm_code)) {
                ?>
                <html><head><title><?php echo self::$__lang['registered_top'] ?></title><style>body{font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;}</style></head><body>
                        <?php echo self::$__lang['registered_confirm_success'] ?>
                    <center><input type="button" onClick="window.location = '../index/<?php echo DEFAULT_PAGE ?>'" value="<?php echo self::$__lang['registered_play_button'] ?>"></center>
                    <?php
                } else {
                    ?>
                    <html><head><title><?php echo self::$__lang['registered_top'] ?></title><style>body{font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; text-decoration: none;}</style></head><body>
                            <?php echo self::$__lang['registered_confirm_error'] ?>			
                        <center><input type="button" onClick="window.location = '../index/<?php echo DEFAULT_PAGE ?>'" value="<?php echo self::$__lang['registered_exit_button'] ?>"></center>			
                        <?php
                    }
                    ?>
                    <?php
                }

                /**
                 * toLogin
                 * 
                 * toLogin function
                 * @param boolean $fromWindowOpener
                 */
                function toLogin($fromWindowOpener = true) {
                    $usr = clean($_REQUEST["usr"]);
                    $pswd = md5($_REQUEST["pswd"]);

                    $query = "select * from pkr_player where usr='" . $usr . "' and pswd='" . $pswd . "'";
                    $rows = $GLOBALS['mydb']->select($query);

                    if (count($rows) == 1) {
                        if ($rows[0]['confirmed'] == 0) {
                            ?>
                            <?php echo self::$__lang['usr_not_confirmed'] ?>
                            <?php
                            if ($fromWindowOpener) {
                                ?>
                                <br>
                                <br>
                                <center><input type="button" onClick="window.close()" value="<?php echo self::$__lang['close_button'] ?>"></center>	
                                <?php
                            } else {
                                ?>
                                <br>
                                <br>
                                <center><input type="button" onClick="window.location = '../index/index.php'" value="<?php echo self::$__lang['retry_button'] ?>"></center>	
                                <?php
                            }
                        } else {

                            $_SESSION['my_idp'] = $rows[0]["idplayer"];
                            $_SESSION['my_usr'] = $rows[0]["usr"];
                            $_SESSION['is_supporter'] = ($rows[0]["supporter"] == 1) ? true : false;

                            $query = "update pkr_player set sess = ?, lastenter = now() where idplayer = ?";
                            $params = array(session_id(), $rows[0]["idplayer"]);
                            $GLOBALS['mydb']->update($query, $params);
                            ?>
                            <?php echo self::$__lang['wait_text'] ?>
                            <?php
                            if ($fromWindowOpener) {
                                ?>			
                                <script language="javascript">
                                    <!--
                                window.opener.document.forms['refresh'].submit();
                                    //setTimeout("window.close()",500);
                                    window.close();
                    -->
                                </script>
                                <?php
                            } else {
                                ?>			
                                <script language="javascript">
                                    <!--
                                window.location = '../index/index.php'
                    -->
                                </script>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <?php echo self::$__lang['login_error'] ?>
                        <script language="javascript">
                            <!--			
                        setTimeout("window.location='../index/index.php'", 3000);
            -->
                        </script>
                        <?php
                    }
                }

                /**
                 * mainMenu
                 * 
                 * mainMenu function
                 */
                function mainMenu() {
                    ?>
                    <table width="800" cellspacing="5">
                        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="main" method="post" onSubmit="if (document.forms['main'].elements['src'].focus && document.forms['main'].elements['src'].value == '')
                                    return false;">

                            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                            <input type="hidden" name="sub_act_value" value="<?php echo PKR_MANAGE_PLAYERS ?>">

                            <tr>
                                <td>
                                    <input type="button" onClick="document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_MANAGE_ROOMS ?>';
                                            document.forms['main'].submit();" value="<?php echo self::$__lang['manage_rooms'] ?>">
                                </td>
                            </tr>			

                            <tr>
                                <td>
                                    <input type="button" onClick="document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_MANAGE_TABLES ?>';
                                            document.forms['main'].submit();" value="<?php echo self::$__lang['manage_tables'] ?>">
                                </td>
                            </tr>		

                            <tr>
                                <td>
                                    <input type="button" onClick="document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_MANAGE_PLAYERS ?>';
                                            document.forms['main'].submit();" value="<?php echo self::$__lang['manage_players'] ?>"><?php echo self::$__lang['search_key_by'] ?><input type="text" size="20" name="src">
                                </td>
                            </tr>		

                            <tr>
                                <td>
                                    <input type="button" onClick="document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_DEL_NOT_CONFIRMED_PLAYERS ?>';
                                            document.forms['main'].submit();" value="<?php echo self::$__lang['delete_players'] ?>">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="button" onClick="if (confirmSubmit('Are you sure ?')) {
                                                document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_INIT_ALL ?>';
                                                document.forms['main'].submit();
                                            } else {
                                                return false;
                                            }" value="<?php echo self::$__lang['initialize'] ?>"><?php echo self::$__lang['truncate'] ?><input type="checkbox" name="truncate" value="si"><?php echo self::$__lang['upd_credit_players'] ?>(>&nbsp;<?php echo PKR_DEFAUL_GET_CREDIT ?>)&nbsp;<input type="checkbox" name="upd_credit" value="si"><?php echo self::$__lang['optimize'] ?><input type="checkbox" name="optimize" value="si">
                                </td>
                            </tr>		

                            <tr>
                                <td>
                                    <input type="button" onClick="if (confirmSubmit('Are you sure ?')) {
                                                document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_RESET_ALL ?>';
                                                document.forms['main'].submit();
                                            } else {
                                                return false;
                                            }" value="<?php echo self::$__lang['reset_all'] ?>">
                                </td>
                            </tr>		

                            <tr>
                                <td>
                                    <input type="button" onClick="document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_NEWSLETTER ?>';
                                            document.forms['main'].submit();" value="<?php echo self::$__lang['newsletter'] ?>">
                                </td>
                            </tr>		


                            <tr>
                            <input type="hidden" name="sub_sub_act_value" value="">
                            <td>
                                <input type="button" onClick="document.forms['main'].elements['sub_act_value'].value = '<?php echo PKR_SHOW_LOGS ?>';
                                        document.forms['main'].submit();" value="<?php echo self::$__lang['view_logs'] ?>">
                            </td>
                            </tr>		

                        </form>

                        <tr><td>&nbsp;</td></tr>		
                        <tr><td><?php echo self::$__lang['system_information_title'] ?></td></tr>		
                        <tr><td><?php echo self::$__lang['paypal_account'] ?> <b><?php echo PAYPAL_ACCOUNT ?></b></td></tr>				
                        <tr><td><?php echo self::$__lang['core_protocol'] ?> <b><?php echo CORE_PROTOCOL ?></b></td></tr>		
                        <tr><td><?php echo self::$__lang['using_memcache'] ?> <b><?php echo (USE_MEMCACHE) ? 'Yes' : 'No' ?></b></td></tr>		
                        <tr><td><?php echo self::$__lang['using_remote_mail'] ?> <b><?php echo (USE_REMOTE_SENDMAIL) ? 'Yes [' . URL_SENDMAIL . ']' : 'No [SMTP]' ?></b></td></tr>				
                        <tr><td>&nbsp;</td></tr>

                        <tr><td><input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';"></td></tr>

                    </table>

                    <br>

                    <table width="800" cellspacing="5">

                    </table>
                    <br><br><br><br><br><br>
                    <?php
                }

                /**
                 * login
                 * 
                 * login function
                 */
                function login() {
                    ?>
                    <table width="200" cellspacing="5">
                        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                            <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                            <input type="hidden" name="sub_act_value" value="<?php echo PKR_LOGIN ?>">
                            <input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_2LOGIN ?>">
                            <tr>
                                <td>
                                    USER
                                </td>

                                <td>
                                    <input type="text" size="23" name="usr" maxlength="30">
                                </td>	
                            </tr>

                            <tr>
                                <td>
                                    PSWD
                                </td>

                                <td>
                                    <input type="password" size="23" name="pswd" maxlength="30">
                                </td>	
                            </tr>	

                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="Login">
                                </td>	
                            </tr>	
                        </form>	
                    </table>

                    <?php
                }

                /**
                 * getRanking
                 * 
                 * getRanking function
                 * @param int $npage
                 */
                function getRanking($npage) {
                    $a = "\\\''";
                    $b = "''";

                    if (empty($npage))
                        $page = 1;
                    else
                        $page = $npage;

                    if ($page > 1)
                        $start = $page * ELEMENTS_PAGE - ELEMENTS_PAGE + 1;
                    else
                        $start = 1;

                    $len = ELEMENTS_PAGE;

                    $query = "select idplayer, supporter, ptg, bonus, 
					virtual_money as credit, 
					(n_credit_update*" . PKR_DEFAUL_GET_CREDIT . ") as u, 
					(virtual_money-(n_credit_update*" . PKR_DEFAUL_GET_CREDIT . ")) as w, 
					usr,
					REPLACE(city, '" . $a . "', '" . $b . "') as city
					from pkr_player where confirmed=1 order by w desc limit " . ($start - 1) . "," . $len;

                    $res = $GLOBALS['mydb']->select($query);
                    return $res;
                }

                /**
                 * viewRanking
                 * 
                 * viewRanking function
                 * @param int $npage
                 */
                function viewRanking($npage) {
                    if (empty($npage))
                        $page = 1;
                    else
                        $page = $npage;

                    $query = "select count(*) as n from pkr_player where confirmed=1";
                    $tot = $GLOBALS['mydb']->select($query);
                    $tot = $tot[0]['n'];
                    ?>
                    <table cellspacing="2" width="100%" align="center">
                        <tr><td>

                                <table width="920" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
                                    <tr>	
                                        <td width="1"><img src="../images/site/tleft.gif" border="0"></td>	
                                        <td width="10%" style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['n'] ?></td>
                                        <td width="1%" colspan="2"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x">&nbsp;</td>
                                        <td width="17%"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['usr'] ?></td>
                                        <td width="10%"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['rank'] ?></td>
                                        <td width="18%"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['points'] ?></td>
                                        <td width="16%"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['credit'] ?></td>
                                        <td width="16%"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['wins'] ?></td>
                                        <td width="15%"  style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x"><?php echo self::$__lang['got'] ?></td>
                                        <td width="1"><img src="../images/site/tright.gif" border="0"></td>
                                    </tr>	

                                    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="viewProfile" method="post">
                                        <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                                        <input type="hidden" name="sub_act_value" value="<?php echo PKR_USRS_PROFILE ?>">
                                        <input type="hidden" name="id" value="">
                                    </form>

                                    <tr><td colspan="10" valign="top">

                                            <table cellspacing="0" cellpadding="6" width="100%" align="center">

                                                <?php
                                                $arr = $this->getRanking($page);

                                                $pages = ceil($tot / ELEMENTS_PAGE);

                                                $i = ($page * ELEMENTS_PAGE) - (ELEMENTS_PAGE - 1);
                                                foreach ($arr as $k) {
                                                    if ($i % 2 == 0) {
                                                        ?>
                                                        <tr bgcolor="#FFE5C1">
                                                            <?php
                                                        } else {
                                                            ?>
                                                        <tr bgcolor="#ffffff">
                                                            <?php
                                                        }

                                                        $supp = "<img src=\"../images/icons/bstar.gif\">";
                                                        ;
                                                        if ($k['supporter'] > 0) {
                                                            $supp = "<img src=\"../images/icons/star.gif\">";
                                                            //if ($arr[$i]['bonus']>0)
                                                            //$bonus = "<img src=\"../images/bonus/".$arr[$i]['bonus'].".png\">";
                                                        }

                                                        $icon = "<img src=\"../images/icons/b1.gif\">";
                                                        if ($i <= 4)
                                                            $icon = "<img src=\"../images/icons/" . $i . ".gif\">";
                                                        ?>	
                                                        <td width="1"><?php echo $i ?>&nbsp;</td>
                                                        <td width="1"><?php echo $icon ?>&nbsp;</td>
                                                        <td width="1"><?php echo $supp ?>&nbsp;</td>
                                                        <td width="125"><a href="#" onClick="document.forms['viewProfile'].elements['id'].value = '<?php echo $k['idplayer'] ?>';
                                                                document.forms['viewProfile'].submit();"><b><u><?php echo strtoupper($k['usr']) ?></u></b>&nbsp;</td>
                                                        <td align="center" width="125"><b><?php echo $GLOBALS['rank'][getPlayerRank($k['ptg'])] ?></b>&nbsp;</td>				
                                                        <td width="150"><b><?php echo $k['ptg'] ?></b>&nbsp;</td>
                                                        <td width="150"><b><?php echo $k['credit'] ?><?php echo PKR_CURRENCY_SYMBOL ?></b>&nbsp;</td>
                                                        <td width="140"><b><font color="#006600"><?php echo $k['w'] ?><?php echo PKR_CURRENCY_SYMBOL ?></font></b>&nbsp;</td>
                                                        <td width="110"><b><font color="#660000"><?php echo $k['u'] ?><?php echo PKR_CURRENCY_SYMBOL ?></font></b>&nbsp;</td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </table>

                                        </td></tr>

                                    <tr><td colspan="10">&nbsp;</td></tr>

                                    <tr><td colspan="10" align="center">
                                            <?php
                                            for ($i = 1; $i <= $pages; $i++) {
                                                ?>
                                                <a href="javascript:document.forms['refresh'].elements['sub_act_value'].value='<?php echo PKR_VIEWRANKING ?>';document.forms['refresh'].elements['page'].value='<?php echo $i ?>';document.forms['refresh'].submit();">
                                                    <?php echo $i ?>
                                                </a>&nbsp;
                                                <?php
                                            }
                                            ?>
                                        </td></tr>

                                    <tr><td colspan="10">&nbsp;</td></tr>	

                                    <tr><td colspan="10" align="center"><input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['refresh'].submit();"></td></tr>
                                </table>

                            </td></tr>
                    </table>

                    <br>
                    <?php
                }

                /**
                 * sendMail2ChangePswd
                 * 
                 * sendMail2ChangePswd function
                 */
                function sendMail2ChangePswd() {
                    ?>	
                    <TABLE border="0"><TR><TD align="center"><br><br><br>
                                <?php
                                if ((!isset($_REQUEST['usr'])) || (!isset($_REQUEST['mail']))) {
                                    ?>			
                                    <table border="0" cellspacing="4" align="center">
                                        <tr>
                                            <td colspan="2" align="center">
                                                <?php echo self::$__lang['change_password'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                                            <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                                            <input type="hidden" name="sub_act_value" value="<?php echo PKR_SND_MAIL_PSWD ?>">
                                            <tr>
                                                <td align="right">
                                                    <?php echo self::$__lang['user'] ?>
                                                </td><td><input type="text" size="25" name="usr">
                                                </td></tr>
                                            <tr><td align="right">
                                                    <?php echo self::$__lang['mail'] ?>
                                                </td><td><input type="text" size="25" name="mail">
                                                </td></tr>

                                            <tr>
                                                <td>
                                                    &nbsp;
                                                </td>
                                            </tr>									

                                            <tr><td colspan="2"><input type="submit" value="<?php echo self::$__lang['send_mail_pass_button'] ?>"></td></tr>
                                        </form>
                                    </table>
                                    <?php
                                } else {
                                    $usr = clean($_REQUEST['usr']);
                                    $mail = clean($_REQUEST['mail']);

                                    $query = "select count(*) as n from pkr_player where confirmed = 1 and (usr='" . $usr . "' and mail='" . $mail . "')";
                                    $n = $GLOBALS['mydb']->select($query);
                                    $n = $n[0]["n"];

                                    if ($n > 0) {
                                        $query = "select pswd from pkr_player where confirmed = 1 and (usr = '" . $usr . "' and mail = '" . $mail . "')";
                                        $pswd = $GLOBALS['mydb']->select($query);
                                        $pswd = $pswd[0]["pswd"];

                                        if (isset($pswd)) {
                                            $this->sendMail($mail, "From: " . CONST_ADMIN_MAIL, self::$__lang['mail_change_pass_obj'], self::$__lang['mail_change_pass_text1'] . _myurl . "?m=" . urlencode($mail) . "&n=" . urlencode($usr) . "&id=$pswd&act_value=" . PKR_WWW . "&sub_act_value=" . PKR_SET_NEW_PSWD . "&a=c");
                                            echo self::$__lang['mail_sent_text'] . $mail;
                                            ?>
                                            <script language="javascript">
                                                <!--
                                            setTimeout("window.close()", 3000);
                    -->
                                            </script>					
                                            <?php
                                        } else
                                            echo self::$__lang['mail_sent_error1_text'];
                                    } else
                                        echo self::$__lang['mail_sent_error2_text'];
                                }
                                ?>
                                <br><br><br></td></tr></table>	
                    <?php
                }

                /**
                 * changePassword
                 * 
                 * changePassword function
                 */
                function changePassword() {
                    ?>
                    <table width="250" align="center">
                        <TR><TD align="center">
                                <?php
                                if ($_REQUEST['sub_act_value'] == PKR_CHANGE_PSWD) {
                                    $usr = clean($_REQUEST['n']);
                                    $mail = clean($_REQUEST['m']);
                                    $id = $_REQUEST['id'];

                                    if ($_REQUEST['newpass'] == $_REQUEST['newpass1']) {
                                        $newpass = md5($_REQUEST['newpass']);

                                        $query = "update pkr_player set pswd=? where usr=? and mail=? and pswd=? ";
                                        $params = array($newpass, $usr, $mail, $id);
                                        $GLOBALS['mydb']->update($query, $params);
                                        ?>
                                        PASSWORD UPDATE
                                        <br>
                                        ...PLEASE WAIT...
                                        <br>
                                        <script language="javascript">
                                            <!--
                                        function gotohome()
                                            {
                                                window.location = '<?php echo _myurl ?>';
                                            }
                                            setTimeout("gotohome()", 3000);
                -->
                                        </script>		
                                        <?php
                                    } else {
                                        ?>
                                        <?php echo self::$__lang['mail_change_pass_error1_text'] ?>
                                        <div align="center"><a href="#" onClick="history.back()"><?php echo self::$__lang['retry_button'] ?></a></div>
                                        <?php
                                    }
                                } else {
                                    if ($_REQUEST['sub_act_value'] == PKR_SET_NEW_PSWD) {
                                        if (($_REQUEST['id'] != "") && ($_REQUEST['a'] == 'c') && (isset($_REQUEST['n'])) && (isset($_REQUEST['m']))) {
                                            $usr = clean($_REQUEST['n']);
                                            $mail = clean($_REQUEST['m']);
                                            $id = $_REQUEST['id'];

                                            $query = "select count(*) as n from pkr_player where confirmed = 1 and pswd = '" . $id . "' and usr = '" . $usr . "' and mail = '" . $mail . "'";
                                            $n = $GLOBALS['mydb']->select($query);
                                            $n = $n[0]["n"];

                                            if ($n > 0) {
                                                ?>
                                                <table width="250" align="center">

                                                    <tr><td colspan="2" align="center"><?php echo self::$__lang['change_password'] ?></td></tr>

                                                    <tr><td colspan="2">&nbsp;</td></tr>

                                                    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                                                        <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                                                        <input type="hidden" name="sub_act_value" value="<?php echo PKR_CHANGE_PSWD ?>">
                                                        <tr><td colspan="2">
                                                                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                                                                <input type="hidden" name="n" value="<?php echo $_REQUEST['n'] ?>">
                                                                <input type="hidden" name="m" value="<?php echo $_REQUEST['m'] ?>">
                                                            </td>
                                                        <tr><td><?php echo self::$__lang['new_passwd'] ?></td><td><input type="password" name="newpass"></td></tr>
                                                        <tr><td><?php echo self::$__lang['retype_new_passwd'] ?></td><td><input type="password" name="newpass1"></td></tr>

                                                        <tr><td colspan="2">&nbsp;</td></tr>

                                                        <tr><td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo self::$__lang['confirm_button'] ?>"></td></tr>						
                                                    </form>
                                                </table>
                                                <?php
                                            } else {
                                                ?>
                                                <?php echo self::$__lang['error'] ?>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </td></tr></table>		
                    <?php
                }

                /**
                 * getListGames
                 * 
                 * getListGames function
                 * @param int $game
                 */
                function getListGames($game) {
                    $query = "select idgame,t.idtable as idtable,name from pkr_game g inner join pkr_table t on g.idtable=t.idtable where end = 1 order by idgame desc, t.idtable limit 100";
                    $res = $GLOBALS['mydb']->select($query);
                    ?>
                    <script language="javascript">
                        <!--
                            function numbersonly(e, decimal) {
                            var key;
                            var keychar;

                            if (window.event) {
                                key = window.event.keyCode;
                            }
                            else if (e) {
                                key = e.which;
                            }
                            else {
                                return true;
                            }
                            keychar = String.fromCharCode(key);

                            if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
                                return true;
                            }
                            else if ((("0123456789").indexOf(keychar) > -1)) {
                                return true;
                            }
                            else if (decimal && (keychar == ".")) {
                                return true;
                            }
                            else
                                return false;
                        }
        -->
                    </script>

                    <br><br><br><br>

                    <table border=0 align="center" width="800">
                        <tr><td colspan=2 align="center">
                                <?php echo self::$__lang['history'] ?>		
                            </td></tr>		

                        <tr><td align="center" colspan=2>
                                &nbsp;
                            </td></tr>		

                        <tr><td>

                                <table align="center">
                                    <tr>
                                    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>">
                                        <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                                        <input type="hidden" name="sub_act_value" value="<?php echo PKR_VIEWGAMEHISTORY ?>">

                                        <td align="center">
                                            <select name="game">
                                                <?php
                                                $c_res = count($res);
                                                for ($i = 0; $i < $c_res; $i++) {
                                                    $sel = "";

                                                    if ($res[$i]["idgame"] == $game)
                                                        $sel = "selected";
                                                    ?>		
                                                    <option value="<?php echo $res[$i]["idgame"] ?>" <?php echo $sel ?>><?php echo self::$__lang["TABLE"] . " " . $res[$i]["name"] . " " . self::$__lang["GAME"] . " #" . $res[$i]["idgame"] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>

                                        </tr>

                                        <tr><td align="center">
                                                &nbsp;
                                            </td></tr>

                                        <tr><td align="center">
                                                <input type="submit" value="<?php echo self::$__lang['viewgame_button'] ?>">&nbsp;<input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['refresh'].submit()">
                                            </td>
                                    </form>

                        </tr>

                    </table>		

                </td><td>

                    <table align="center">
                        <tr>

                        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>">
                            <input type="hidden" name="act_value" value="<?php echo PKR_WWW ?>">
                            <input type="hidden" name="sub_act_value" value="<?php echo PKR_VIEWGAMEHISTORY ?>">

                            <td align="center">
                                <?php echo self::$__lang["GAME"] ?> #<input type="text" name="game" onKeyPress="return numbersonly(event, false)">
                            </td>

                            </tr>

                            <tr><td align="center">
                                    &nbsp;
                                </td></tr>

                            <tr><td align="center">
                                    <input type="submit" value="<?php echo self::$__lang['searchgame_button'] ?>">&nbsp;<input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['refresh'].submit()">
                                </td>
                        </form>

                    </tr>
                </table>

            </td></tr>

        <tr><td colspan=2>
                <?php
                $this->getHistoryDataGame($game);
                ?>
            </td></tr>

        <tr><td height="268" colspan=2>
            </td></tr>		

        </table>
        <?php
    }

    /**
     * getHistoryDataGame
     * 
     * getHistoryDataGame function
     * @param int $game
     */
    function getHistoryDataGame($game) {
        if (empty($game))
            return;

        $cols = 5;

        $query = "select g.idtable as idtable, name, type_game from pkr_game g left join pkr_table t on g.idtable = t.idtable where idgame=" . $game;
        $rs = $GLOBALS['mydb']->select($query);
        $tblname = $rs[0]['name'];
        $type_game = $rs[0]['type_game'];
        $idtbl = $rs[0]['idtable'];

        $n_cards = 2;
        if ($type_game == FIVECARD)
            $n_cards = 5;

        if ($type_game == HOLDEM)
            $query = "select idsubhand,time,seat_number,player,usr,type_hand,type_subhand,response from (pkr_subhand s left join pkr_hand h on s.hand=h.idhand) left join pkr_player p on s.player=p.idplayer where s.game=" . $game . " and h.type_hand in ('postblinds','preflop','flop','turn','river') order by idsubhand asc";
        else
            $query = "select idsubhand,time,seat_number,player,usr,type_hand,type_subhand,response from (pkr_subhand s left join pkr_hand h on s.hand=h.idhand) left join pkr_player p on s.player=p.idplayer where s.game=" . $game . " and h.type_hand in ('postblinds','firstround','draw','secondround') order by idsubhand asc";

        $rows['history']['hands'] = $GLOBALS['mydb']->select($query);

        $query = "select idsubpost,seat,player,post,isallin from pkr_subpost where game=" . $game . " order by idsubpost asc";
        $rows['history']['posts'] = $GLOBALS['mydb']->select($query);

        if ($type_game == HOLDEM) {
            $query = "select card,seed from pkr_dealer where game=" . $game . " and seat = 0 order by seat,number";
            $rows['history']['board_cards'] = $GLOBALS['mydb']->select($query);
        }

        $query = "select card,seed,usr,seat from pkr_dealer d left join pkr_player p on d.player=p.idplayer where game=" . $game . " and (seat > 0 and seat < 11) and seat in (select seat from pkr_game_win where game=" . $game . " and rank != 'opponents fold') order by seat,number";
        $rows['history']['player_cards'] = $GLOBALS['mydb']->select($query);

        $query = "select usr, player, seat, best5, rank, pot, number from pkr_game_win d left join pkr_player p on d.player=p.idplayer where game=" . $game;
        $rows['history']['winners'] = $GLOBALS['mydb']->select($query);

        echo "<table align=\"center\"><tr><td>";

        echo "<table width=\"800\" align=\"center\"><tr><td>";

        echo "<table cellspacing=\"5\" align=\"center\" width=\"500\" border=0 style=\"BORDER-RIGHT: #dddddd 4px solid; BORDER-TOP: #dddddd 4px solid; BORDER-LEFT: #dddddd 4px solid; BORDER-BOTTOM: #dddddd 4px solid\">";

        echo "<tr><td colspan=" . $cols . ">";
        echo "<font size=\"3\"><b>" . self::$__lang["TABLE"] . " #" . $idtbl . " " . $tblname . "</b></font>";
        echo "</td></tr>";

        echo "<tr><td colspan=" . $cols . ">";
        echo "<font size=\"3\"><b>" . self::$__lang["GAME"] . " #" . $game . "</b></font>";
        echo "</td></tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">";
        echo self::$__lang['history_board_cards'];
        echo "</td></tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        if ($type_game == HOLDEM) {
            echo "<tr><td colspan=" . $cols . ">";

            for ($i = 0; $i < count($rows['history']['board_cards']); $i++) {
                $arr_b = $rows['history']['board_cards'][$i];
                //echo $arr_b["card"]." ".$arr_b["seed"]." ";
                $this->cs2img($arr_b["card"], $arr_b["seed"]);
            }

            echo "</td></tr>";
        }

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">" . self::$__lang['history_player_cards'] . "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        for ($i = 0; $i < count($rows['history']['player_cards']); $i+=$n_cards) {
            echo "<tr><td colspan=" . $cols . ">";
            echo self::$__lang["seat"] . " " . $rows['history']['player_cards'][$i]["seat"] . " <b>" . $rows['history']['player_cards'][$i]["usr"] . "</b><br>";
            for ($n = 0; $n < $n_cards; $n++) {
                $arr_b = $rows['history']['player_cards'][$i + $n];
                $this->cs2img($arr_b["card"], $arr_b["seed"]);
            }
            echo "</td></tr>";
        }
        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">" . self::$__lang['history_hands'] . "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        $tot = 0;

        for ($i = 0; $i < count($rows['history']['hands']); $i++) {
            if ($i % 2 == 0)
                echo "<tr bgcolor=#dddddd>";
            else
                echo "<tr bgcolor=#eeeeee>";

            $arr_h = $rows['history']['hands'][$i];
            $arr_p = $rows['history']['posts'][$i];
            if ($arr_h["response"] != "continue") {
                $tot += $arr_p["post"];

                if ($arr_p["isallin"] == 1) {
                    if ($arr_p["post"] > 0)
                    //echo "<td>[".strtoupper($arr_h["type_hand"])."]</td><td>SEAT ".$arr_h["seat_number"]."</td><td><b>".$arr_h["usr"]."</b> (".$arr_h["player"].")</td><td>".strtoupper($arr_h["response"])."</td><td>".$arr_p["post"].PKR_CURRENCY_SYMBOL." [ALLIN]";
                        echo "<td>[" . strtoupper($arr_h["type_hand"]) . "]</td><td>" . self::$__lang['seat'] . " " . $arr_h["seat_number"] . "</td><td><b>" . $arr_h["usr"] . "</b></td><td>" . strtoupper($arr_h["response"]) . "</td><td>" . $arr_p["post"] . PKR_CURRENCY_SYMBOL . " [ALLIN]";
                    else
                    //echo "<td>[".strtoupper($arr_h["type_hand"])."]</td><td>SEAT ".$arr_h["seat_number"]."</td><td><b>".$arr_h["usr"]."</b> (".$arr_h["player"].")</td><td colspan=2>".strtoupper($arr_h["response"])."</td>";
                        echo "<td>[" . strtoupper($arr_h["type_hand"]) . "]</td><td>" . self::$__lang['seat'] . " " . $arr_h["seat_number"] . "</td><td><b>" . $arr_h["usr"] . "</b></td><td colspan=2>" . strtoupper($arr_h["response"]) . "</td>";
                }
                else {
                    if ($arr_p["post"] > 0)
                    //echo "<td>[".strtoupper($arr_h["type_hand"])."]</td><td>SEAT ".$arr_h["seat_number"]."</td><td><b>".$arr_h["usr"]."</b> (".$arr_h["player"].")</td><td>".strtoupper($arr_h["response"])."</td><td>".$arr_p["post"].PKR_CURRENCY_SYMBOL;
                        echo "<td>[" . strtoupper($arr_h["type_hand"]) . "]</td><td>" . self::$__lang['seat'] . " " . $arr_h["seat_number"] . "</td><td><b>" . $arr_h["usr"] . "</b></td><td>" . strtoupper($arr_h["response"]) . "</td><td>" . $arr_p["post"] . PKR_CURRENCY_SYMBOL;
                    else
                    //echo "<td>[".strtoupper($arr_h["type_hand"])."]</td><td>SEAT ".$arr_h["seat_number"]."</td><td><b>".$arr_h["usr"]."</b> (".$arr_h["player"].")</td><td colspan=2>".strtoupper($arr_h["response"])."</td>";
                        echo "<td>[" . strtoupper($arr_h["type_hand"]) . "]</td><td>" . self::$__lang['seat'] . " " . $arr_h["seat_number"] . "</td><td><b>" . $arr_h["usr"] . "</b></td><td colspan=2>" . strtoupper($arr_h["response"]) . "</td>";
                }
            }
            echo "</tr>";
        }

        echo "<tr>";
        echo "<td colspan=" . ($cols - 1) . "></td><td><b>" . number_format($tot, 2) . PKR_CURRENCY_SYMBOL . "</b> " . self::$__lang['total'] . "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . "><font size=\"2\"><b>" . self::$__lang['winners'] . "</b></font></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan=" . $cols . ">&nbsp;</td>";
        echo "</tr>";

        if (isset($rows['history']['winners'])) {
            for ($i = 0; $i < count($rows['history']['winners']); $i++) {
                echo "<tr><td colspan=" . $cols . ">";
                $arr_w = $rows['history']['winners'][$i];
                echo self::$__lang["seat"] . " " . $arr_w["seat"] . " <b>" . $arr_w["usr"] . "</b> (" . $arr_w["player"] . ") <b>" . strtoupper(str_replace("opponents fold", self::$__lang['opponent_fold'], $arr_w["rank"])) . "</b> " . $arr_w["pot"] . PKR_CURRENCY_SYMBOL;
                if ($arr_w["rank"] != 'opponents fold') {
                    echo "<br><br>";
                    $arr = split("-", $arr_w["best5"]);
                    for ($j = 0; $j < count($arr); $j++) {
                        $card = substr($arr[$j], 0, strlen($arr[$j]) - 1);
                        $seed = substr($arr[$j], strlen($arr[$j]) - 1, strlen($arr[$j]));
                        $this->cs2img($card, $seed);
                    }
                }
                echo "</td></tr>";
            }
        } else
            echo "<tr><td colspan=" . $cols . ">" . self::$__lang['no_winners'] . "</td></tr>";

        echo "</table>";

        echo "</td></tr></table>";

        echo "</td></tr></table>";
    }

    /**
     * t
     * 
     * t function
     * @param string $c
     */
    function t($c) {
        switch ($c) {
            case 'A':
                return 1;
                break;
            case 'J':
                return 11;
                break;
            case 'Q':
                return 12;
                break;
            case 'K':
                return 13;
                break;
            default:
                return $c;
                break;
        }
    }

    /**
     * cs2img
     * 
     * cs2img function
     * @param string $c
     * @param string $s
     */
    function cs2img($c, $s) {
        $cint = $this->t($c);

        switch ($s) {
            case 'c':
                $file = ($cint + 13) . ".gif";
                break;
            case 'q':
                $file = ($cint + 39) . ".gif";
                break;
            case 'f':
                $file = $cint . ".gif";
                break;
            case 'p':
                $file = ($cint + 26) . ".gif";
                break;
        }
        echo "<img src=\"../images/cards/" . $file . "\"/>";
    }

    /**
     * getPTG
     * 
     * getPTG function
     * @param string $cards Cards � una stringa fatta cosi Ac,Jc,...
     * @param string $comma
     */
    function getPTG($cards, $comma = ',') {
        $arr = split($comma, $cards);
        for ($j = 0; $j < count($arr); $j++) {
            $card = substr($arr[$j], 0, strlen($arr[$j]) - 1);
            $seed = substr($arr[$j], strlen($arr[$j]) - 1, strlen($arr[$j]));
            $this->cs2img($card, $seed);
        }
    }

    /**
     * getRules
     * 
     * getRules function
     */
    function getRules() {
        ?>
        <table width="899" align="center" cellpadding="2">

            <tr><td>
                    &nbsp;
                </td></tr>	

            <tr><td align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['refresh'].submit()">
                </td></tr>	

            <tr><td>
                    &nbsp;
                </td></tr>	

            <tr><td>
                    <?php echo self::$__lang['texasholdem_rules'] ?>
                </td></tr>

            <tr><td>
                    &nbsp;
                </td></tr>

            <tr><td>
                    <?php echo self::$__lang['fivecards_rules'] ?>
                </td>
            </tr>
            <tr><td>
                    <?php echo $__lang['rules_points'] ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_royal'] ?>
                    <br>
                    <?php
                    $this->getPTG("Ap,Kp,Qp,Jp,10p");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_straight_flush'] ?>

                    <br>
                    <?php
                    $this->getPTG("10q,9q,8q,7q,6q");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_four_of_a_kind'] ?>

                    <br>
                    <?php
                    $this->getPTG("Kc,Kq,Kf,Kpq,10q");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_full_house'] ?>

                    <br>
                    <?php
                    $this->getPTG("7q,7c,7f,Aq,Ac");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_flush'] ?>

                    <br>
                    <?php
                    $this->getPTG("2q,3q,Kq,Qq,10q");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_straight'] ?>

                    <br>
                    <?php
                    $this->getPTG("7q,6c,5q,4q,3f");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_three_of_a_kind'] ?>
                    <br>
                    <?php
                    $this->getPTG("Qq,Qc,Qf,2q,10f");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_two_pair'] ?>
                    <br>
                    <?php
                    $this->getPTG("Ap,Ac,Qq,Qf,8f");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_one_pair'] ?>
                    <br>
                    <?php
                    $this->getPTG("Kq,Kc,2q,1q,10c");
                    ?>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_high_card'] ?>
                    <br>
                    <?php
                    $this->getPTG("Aq,6c,2p,4p,3p");
                    ?>
                    <br>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_points_text'] ?>
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <br>
                    <?php echo self::$__lang['rules_points_text2'] ?>
                    <br>
                </td></tr>
        </table>
        <?php
    }

    /**
     * toAdminLogin
     * 
     * toAdminLogin function
     */
    function toAdminLogin() {
        $usr = clean($_REQUEST["usr"]);
        $pswd = md5($_REQUEST["pswd"]);

        if (($usr == PKR_USR_ADMIN) && ($pswd == PKR_PSWD_ADMIN)) {
            $_SESSION['admin'] = $rows[0]["usr"];

            $query = "update pkr_player set sess = ? where idplayer = ?";
            $params = array(session_id(), $rows[0]["idplayer"]);
            $GLOBALS['mydb']->update($query, $params);
            ?>			
            <?php echo self::$__lang['wait_text'] ?>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" name="myform">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">
            </form>
            <script language="javascript">
            <!--
                document.forms['myform'].submit();
            -->
            </script>
            <?php
        } else {
            ?>			
            <?php echo self::$__lang['login_error_wait'] ?>			
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" name="myform">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_LOGIN ?>">
            </form>
            <script language="javascript">
            <!--
                function go() {
                    document.forms['myform'].submit();
                }
                setTimeout("go()", 3000);
            -->
            </script>
            <?php
        }
    }

    /**
     * prepareNewsletter
     *
     * Prepare newsletter form
     */
    function prepareNewsletter() {
        ?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">			
        </form>
        <?php echo self::$__lang['newsletter_title'] ?>

        <br><br><br>
        <table align=center width="200" cellspacing="5">
            <tr>

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="newsletter" method="post" onSubmit="if ((document.forms['newsletter'].elements['subject'].value == '') || (document.forms['newletter'].elements['body'].value == '')) {
                        alert('Riempire tutti i campi !');
                        return false;
                    }">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_NEWSLETTER ?>">
                <input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_SEND_NEWSLETTER ?>">	
                <td colspan="2">
                    <?php echo self::$__lang['newsletter_subject'] ?>
                    <input type="text" size="50" name="subject">	
                </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <?php echo self::$__lang['newsletter_body'] ?>
                        <textarea name="body" rows="10" cols="100"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" value="INVIA NEWSLETTER">&nbsp;<input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">
                    </td>		

                </tr>
            </form>			
        </table>
        <br><br><br><br><br><br><br><br><br><br><br><br><br>

        <?php
    }

    /**
     * sendNewsletter
     * 
     * sendNewsletter function
     * @param string $subject
     * @param string $body
     * @param string $bcc
     * @return boolean
     */
    function sendNewsletter($subject, $body, $bcc) {
        $target = CONST_ADMIN_MAIL;
        $header = "From: noreply@flashpoker
	               bcc: $bcc
	    		   ";

        echo "<div width='100%'>" . str_replace(",", ", ", $bcc) . "</div>";

        //if ($this->sendMail($target,$header,$subject,$body))
        if (mail($target, $subject, $body, $header))
            return true;
        else
            return false;
    }

    /**
     * adminLogin
     * 
     * adminLogin function
     */
    function adminLogin() {
        ?>
        <?php echo self::$__lang['admin_title'] ?>
        <table align=center width="200" cellspacing="5">
            <tr>

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="main" method="post" onSubmit="if ((document.forms['main'].elements['usr'].value == '') && (document.forms['main'].elements['pswd'].value == ''))
                        return false;">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_LOGIN ?>">
                <input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_2LOGIN ?>">		
                <td>
                    <?php echo self::$__lang['admin_user'] ?>
                </td>

                <td>
                    <input type="text" size="23" name="usr" maxlength="30">
                </td>	
                </tr>

                <tr>
                    <td>
                        <?php echo self::$__lang['admin_pass'] ?>
                    </td>

                    <td>
                        <input type="password" size="23" name="pswd" maxlength="30">
                    </td>	
                </tr>	

                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="<?php echo self::$__lang['login_button'] ?>">&nbsp;<input type="button" value="<?php echo self::$__lang['exit_button'] ?>" onClick="window.location = '../index/index.php'">
                    </td>	
            </form>
        </tr>	
        </table>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <?php
    }

    /**
     * topAdmin
     * 
     * topAdmin function
     */
    function topAdmin() {
        ?>	
        <table width="0" cellspacing="2" cellpadding="0" align="center">
            <tr><td align="center">
                    <img src="../images/site/logopoker.gif" border="0">
                </td></tr><tr><td align="center"><?php echo self::$__lang['admin_top_logo_description'] ?></td></tr>
        </table>	
        <table cellspacing="2" cellpadding="0" align="center" width="100%">
            <tr><td>
                    <?php echo self::$__lang['admin_title_2'] ?>
                </td></tr>
        </table>	
        <?php
    }

    /**
     * getArrRooms
     * 
     * getArrRooms function
     * @param int $npage
     */
    function getArrRooms($npage) {
        if (empty($npage))
            $page = 1;
        else
            $page = $npage;

        if ($page > 1)
            $start = $page * ELEMENTS_PAGE - ELEMENTS_PAGE;
        else
            $start = 1;

        $len = ELEMENTS_PAGE;

        $query = "select * from pkr_room limit " . ($start - 1) . "," . $len;
        $res = $GLOBALS['mydb']->select($query);
        return $res;
    }

    /**
     * getArrTbls
     * 
     * getArrTbls function
     * @param int $npage
     */
    function getArrTbls($npage) {
        if (empty($npage))
            $page = 1;
        else
            $page = $npage;

        if ($page > 1)
            $start = $page * ELEMENTS_PAGE - ELEMENTS_PAGE;
        else
            $start = 1;

        $len = ELEMENTS_PAGE;

        $query = "select * from pkr_table limit " . ($start - 1) . "," . $len;
        $res = $GLOBALS['mydb']->select($query);
        return $res;
    }

    /**
     * manageRooms
     * 
     * manageRooms function
     */
    function manageRooms() {
        $npage = $_REQUEST['page'];
        if (empty($npage))
            $page = 1;
        else
            $page = $npage;

        $query = "select count(*) as n from pkr_room";
        $tot = $GLOBALS['mydb']->select($query);
        $tot = $tot[0]['n'];
        ?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="myform" method="post">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="<?php echo PKR_MANAGE_ROOMS ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
        </form>

        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="actform" method="get">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="src" value="<?php echo $src ?>">
            <input type="hidden" name="idroom" value="">
        </form>				

        <?php
        $this->insertRoomForm();
        ?>

        <br>
        <table width="800" border="0" cellspacing="0" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; border:1px solid; border-color:black; border-collapse: collapse">		
            <tr style="font-weight: bold; color: white"  bgcolor="#000000">
                <td width="1%"><?php echo self::$__lang['N'] ?></td>
                <td width="34%"><?php echo self::$__lang['name'] ?></td>
                <td width="35%"><?php echo self::$__lang['pass'] ?></td>
                <td width="10%"><?php echo self::$__lang['type'] ?></td>
                <td width="10%"><?php echo self::$__lang['status'] ?></td>
                <td width="1%"><?php echo self::$__lang['act'] ?></td>		
            </tr>	

            <?php
            $arr = $this->getArrRooms($page);

            $pages = ceil($tot / ELEMENTS_PAGE);

            $i = ($page * ELEMENTS_PAGE) - (ELEMENTS_PAGE - 1);
            foreach ($arr as $k) {
                if ($i % 2 == 0) {
                    ?>
                    <tr bgcolor="#ffffff">
                        <?php
                    } else {
                        ?>
                    <tr bgcolor="#dddddd">
                        <?php
                    }
                    ?>	

                    <td><?php echo $i ?></td>
                    <td><?php echo strtoupper($k['name']) ?></td>
                    <td><b><?php echo $k['password'] ?></b></td>
                    <td><b><font color="#660000"><?php echo $k['type'] ?></font></b></td>
                    <td><?php echo $k['status'] ?></td>
                    <td align="center"><input type="image" src="../images/del.gif" border="0" onClick="if (confirmSubmit('<?php echo self::$__lang['alert_delete_warning_text'] ?>')) {
                                document.forms['actform'].elements['idroom'].value = '<?php echo $k['idroom'] ?>';
                                document.forms['actform'].elements['sub_act_value'].value = '<?php echo PKR_DEL_ROOM ?>';
                                document.forms['actform'].submit();
                            } else {
                                return false;
                            }"></td>

                </tr>
                <?php
                $i++;
            }
            ?>
            <tr><td colspan="6" align="center">
                    <?php
                    for ($i = 1; $i <= $pages; $i++) {
                        ?>
                        <a href="javascript:document.forms['myform'].elements['page'].value='<?php echo $i ?>';document.forms['myform'].submit();">
                            <?php echo $i ?>
                        </a>&nbsp;
                        <?php
                    }
                    ?>
                </td></tr>

            <tr>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">			
                <td colspan="6" align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                </td>
            </form>
        </tr>

        </table>		

        <?php
    }

    function back($msg) {
        ?>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <table width="800" cellspacing="0" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
            <tr>
                <td align="center">
                    <b><?php echo $msg ?></b>
                </td>
            </tr>
            <tr>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">			
                <td align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">
                </td>
            </form>
        </tr>
        </table>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <?php
    }

    /**
     * manageTbls
     * 
     * manageTbls function
     */
    function manageTbls() {
        $npage = $_REQUEST['page'];
        if (empty($npage))
            $page = 1;
        else
            $page = $npage;

        $query = "select count(*) as n from pkr_table";
        $tot = $GLOBALS['mydb']->select($query);
        $tot = $tot[0]['n'];
        ?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="myform" method="post">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="<?php echo PKR_MANAGE_TABLES ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
        </form>

        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="actform" method="get">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="src" value="<?php echo $src ?>">
            <input type="hidden" name="idtable" value="">
        </form>				

        <?php
        $this->insertTableForm();

        $query = "select idroom, name from pkr_room order by idroom";
        $rooms = $GLOBALS['mydb']->special_select($query, 'idroom');
        $rooms[0]['name'] = "Main Room";
        ?>

        <br>
        <table width="800" border="0" cellspacing="0" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; border:1px solid; border-color:black; border-collapse: collapse">		
            <tr style="font-weight: bold; color: white"  bgcolor="#000000">
                <td width="1%"><?php echo self::$__lang['n'] ?></td>
                <td width="9%"><?php echo self::$__lang['room'] ?></td>
                <td width="11%"><?php echo self::$__lang['name'] ?></td>
                <td width="6%"><?php echo self::$__lang['plrs'] ?></td>
                <td width="6%"><?php echo self::$__lang['smin'] ?></td>
                <td width="6%"><?php echo self::$__lang['smax'] ?></td>
                <td width="6%"><?php echo self::$__lang['limited'] ?></td>	
                <td width="1%"><?php echo self::$__lang['act'] ?></td>		
            </tr>		

            <?php
            $arr = $this->getArrTbls($page);

            $pages = ceil($tot / ELEMENTS_PAGE);

            $i = ($page * ELEMENTS_PAGE) - (ELEMENTS_PAGE - 1);
            foreach ($arr as $k) {
                if ($i % 2 == 0) {
                    ?>
                    <tr bgcolor="#ffffff">
                        <?php
                    } else {
                        ?>
                    <tr bgcolor="#dddddd">
                        <?php
                    }
                    ?>	

                    <td><?php echo $i ?></td>
                    <td><?php echo strtoupper($rooms[$k['room']]['name']) ?></td>
                    <td><b><?php echo strtoupper($k['name']) ?></b></td>
                    <td><b><font color="#660000"><?php echo $k['max_plrs'] ?></font></b></td>
                    <td><?php echo $k['stakes_min'] ?></td>
                    <td><?php echo $k['stakes_max'] ?></td>
                    <td><b><font color="#006600"><?php echo $k['limited'] ?></font></b></td>
                    <!--<td align="center"><input type="image" src="../images/mod.gif" border="0" onClick="document.forms['actform'].elements['idtable'].value='<?php echo $k['idtable'] ?>';document.forms['actform'].elements['sub_act_value'].value='<?php echo PKR_MOD_TABLE ?>';document.forms['actform'].submit();"></td>-->
                    <td align="center"><input type="image" src="../images/del.gif" border="0" onClick="if (confirmSubmit('<?php echo self::$__lang['alert_delete_warning_text'] ?>')) {
                                document.forms['actform'].elements['idtable'].value = '<?php echo $k['idtable'] ?>';
                                document.forms['actform'].elements['sub_act_value'].value = '<?php echo PKR_DEL_TABLE ?>';
                                document.forms['actform'].submit();
                            } else {
                                return false;
                            }"></td>

                </tr>
                <?php
                $i++;
            }
            ?>
            <tr><td colspan="8" align="center">
                    <?php
                    for ($i = 1; $i <= $pages; $i++) {
                        ?>
                        <a href="javascript:document.forms['myform'].elements['page'].value='<?php echo $i ?>';document.forms['myform'].submit();">
                            <?php echo $i ?>
                        </a>&nbsp;
                        <?php
                    }
                    ?>
                </td></tr>

            <tr>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">			
                <td colspan="8" align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                </td>
            </form>
        </tr>

        </table>		

        <?php
    }

    /**
     * getRoomsSelect
     * 
     * getRoomsSelect function
     */
    function getRoomsSelect() {
        $str = "<select name=\"room\">";
        $str .= "<option value=0>" . self::$__lang['main_room'] . "</option>";
        $query = "select * from pkr_room";
        $res = $GLOBALS['mydb']->select($query);
        foreach ($res as $n => $arr)
            $str .= "<option value=" . $arr['idroom'] . ">" . $arr['name'] . "</option>";
        $str .= "</select>";
        return $str;
    }

    /**
     * insertRoomForm
     * 
     * insertRoomForm function
     */
    function insertRoomForm() {
        //idroom, name, password, type, status
        ?>
        <?php echo self::$__lang['insert_new_room'] ?>
        <table width="800" border="0" cellspacing="0" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; border:1px solid; border-color:black; border-collapse: collapse">

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="ins" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_CREATEROOM ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">

                <tr style="font-weight: bold; color: white"  bgcolor="#000000">	
                    <td><?php echo self::$__lang['name'] ?></td>			
                    <td><?php echo self::$__lang['pass'] ?></td>			
                    <td><?php echo self::$__lang['type'] ?></td>			
                    <td><?php echo self::$__lang['status'] ?></td>			
                    <td>&nbsp;</td>			
                </tr>		

                <tr bgcolor="#EEEEEE">

                    <td>
                        <input type="text" name="name" size="50">
                    </td>
                    <td>
                        <input type="text" name="password" size="50">
                    </td>
                    <td>
                        <select name="type">
                            <option value="0"><?php echo self::$__lang['public'] ?></option>
                            <option value="1"><?php echo self::$__lang['private'] ?></option>				
                        </select>
                    </td>
                    <td>
                        <select name="status">
                            <option value="1"><?php echo self::$__lang['open'] ?></option>
                            <option value="0"><?php echo self::$__lang['close'] ?></option>				
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo self::$__lang['create_button'] ?>">
                    </td>			
                </tr>	

            </form>
        </table>
        <?php
    }

    /**
     * insertTableForm
     * 
     * insertTableForm function
     */
    function insertTableForm() {
        ?>
        <?php echo self::$__lang['insert_new_table'] ?>
        <table width="800" border="1" cellspacing="0" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; border:1px solid; border-color:black; border-collapse: collapse">

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="ins" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_CREATETBL ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">

                <tr style="font-weight: bold; color: white"  bgcolor="#000000">
                    <td><?php echo self::$__lang['room'] ?></td>	
                    <td><?php echo self::$__lang['name'] ?></td>			
                    <td><?php echo self::$__lang['smin'] ?></td>			
                    <td><?php echo self::$__lang['smax'] ?></td>			
                    <td><?php echo self::$__lang['limited'] ?></td>			
                    <td><?php echo self::$__lang['plrs'] ?></td>			
                    <td><?php echo self::$__lang['allin'] ?></td>	
                    <td><?php echo self::$__lang['typegame'] ?></td>			
                    <td>&nbsp;</td>			
                </tr>		

                <tr bgcolor="#EEEEEE">

                    <td>
                        <?php echo $this->getRoomsSelect() ?>
                    </td>		

                    <td>
                        <input type="text" name="name" size="35">
                    </td>
                    <td>
                        <input type="text" name="stakes_min" size="5" value="10">
                    </td>
                    <td>
                        <input type="text" name="stakes_max" size="5" value="20">
                    </td>
                    <td>
                        <select name="limited">
                            <option value="NL"><?php echo self::$__lang['no_limit'] ?></option>
                        </select>
                    </td>
                    <td>
                        <select name="max_plrs">
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                        </select>
                    </td>

                    <td>
                        <select name="all_in">
                            <option value="1"><?php echo self::$__lang['si'] ?></option>
                            <option value="0"><?php echo self::$__lang['no'] ?></option>
                        </select>		
                    </td>

                    <td>
                        <select name="type_game">
                            <option value="holdem"><?php echo self::$__lang['texas_holdem'] ?></option>
                            <option value="fivecard"><?php echo self::$__lang['five_cards_draw'] ?></option>
                        </select>		
                    </td>		

                    <td>
                        <input type="submit" value="<?php echo self::$__lang['create_button'] ?>">
                    </td>			
                </tr>	

            </form>
        </table>
        <?php
    }

    /**
     * doAlert
     * 
     * doAlert function
     * @param string $msg
     */
    function doAlert($msg) {
        ?>
        <script language="javascript">alert(<?php echo $msg ?>);</script>
        <?php
    }

    /**
     * getArrPlrs
     * 
     * getArrPlrs function
     * @param int $npage
     * @param boolean $searching	
     * @param string $src	
     */
    function getArrPlrs($npage, $searching = false, $src = "") {
        $a = "\\\''";
        $b = "''";

        if (empty($npage))
            $page = 1;
        else
            $page = $npage;

        if ($page > 1)
            $start = $page * ELEMENTS_PAGE - ELEMENTS_PAGE;
        else
            $start = 1;

        $len = ELEMENTS_PAGE;

        if ($searching)
            $query = "select idplayer,usr,mail,REPLACE(city, '" . $a . "', '" . $b . "') as city,virtual_money,confirmed,supporter from pkr_player where usr like '%" . $src . "%' or mail like '%" . $src . "%' order by confirmed desc limit " . ($start - 1) . "," . $len;
        else
            $query = "select idplayer,usr,mail,REPLACE(city, '" . $a . "', '" . $b . "') as city,virtual_money,confirmed,supporter from pkr_player order by confirmed desc limit " . ($start - 1) . "," . $len;
        $res = $GLOBALS['mydb']->select($query);
        return $res;
    }

    /**
     * managePlrs
     * 
     * managePlrs function
     */
    function managePlrs() {
        $colspan = 9;

        $searching = false;
        if (isset($_REQUEST['src'])) {
            $searching = true;
            $src = $_REQUEST['src'];
            $src = str_replace("'", "''", $src);
        }

        $npage = $_REQUEST['page'];
        if (empty($npage))
            $page = 1;
        else
            $page = $npage;

        if ($searching)
            $query = "select count(*) as n from pkr_player where usr like '%" . $src . "%' or mail like '%" . $src . "%'";
        else
            $query = "select count(*) as n from pkr_player";
        $tot = $GLOBALS['mydb']->select($query);
        $tot = $tot[0]['n'];
        ?>

        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="myform" method="post">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="<?php echo PKR_MANAGE_PLAYERS ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="src" value="<?php echo $src ?>">
        </form>

        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="actform" method="get">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="src" value="<?php echo $src ?>">
            <input type="hidden" name="idplayer" value="">
        </form>		

        <table width="800" border="0" cellspacing="0">
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MANAGE_PLAYERS ?>">
                <tr>
                    <td>
                        <input type="submit" value="SEARCH">&nbsp;<input type="text" size="20" name="src" value="<?php echo $_REQUEST['src'] ?>">
                    </td>
                </tr>
            </form>
        </table>		

        <table width="800" border="1" cellspacing="0" cellpadding="2" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; border:1px solid; border-color:black; border-collapse: collapse">		
            <tr style="font-weight: bold; color: white"  bgcolor="#000000">
                <td width="3%"><?php echo self::$__lang['n'] ?></td>
                <td width="20%"><?php echo self::$__lang['usr'] ?></td>
                <td width="15%"><?php echo self::$__lang['mail'] ?></td>
                <td width="25%"><?php echo self::$__lang['city'] ?></td>
                <td width="15%"><?php echo self::$__lang['credi'] ?></td>			
                <td width="1%"><?php echo self::$__lang['c'] ?></td>
                <td width="1%"><?php echo self::$__lang['supp'] ?></td>
                <td width="1%" colspan="2"><?php echo self::$__lang['act'] ?></td>
            </tr>		

            <?php
            $arr = $this->getArrPlrs($page, $searching, $src);

            $pages = ceil($tot / ELEMENTS_PAGE);

            $i = ($page * ELEMENTS_PAGE) - (ELEMENTS_PAGE - 1);
            if (!empty($arr)) {
                foreach ($arr as $k) {
                    if ($i % 2 == 0) {
                        ?>
                        <tr bgcolor="#ffffff">
                            <?php
                        } else {
                            ?>
                        <tr bgcolor="#dddddd">
                            <?php
                        }
                        ?>	

                        <td><?php echo $i ?></td>
                        <td><b><?php echo strtoupper($k['usr']) ?></b></td>
                        <td><b><font color="#660000"><?php echo $k['mail'] ?></font></b></td>
                        <td><?php echo $k['city'] ?></td>
                        <td><b><?php echo number_format($k['virtual_money'], 2) ?><?php echo PKR_CURRENCY_SYMBOL ?></b></td>
                        <td><b><font color="#006600"><?php
                                if ($k['confirmed'] == 1)
                                    echo "Y";
                                else
                                    echo "N";
                                ?></font></b></td>
                        <td align="center"><b><?php echo $k['supporter'] ?></b></td>
                        <td align="center"><input type="image" src="../images/mod.gif" border="0" onClick="document.forms['actform'].elements['idplayer'].value = '<?php echo $k['idplayer'] ?>';
                                document.forms['actform'].elements['sub_act_value'].value = '<?php echo PKR_MOD_PLAYER ?>';
                                document.forms['actform'].submit();"></td>
                        <td align="center"><input type="image" src="../images/del.gif" border="0" onClick="if (confirmSubmit('Are you sure to delete this player ?')) {
                                    document.forms['actform'].elements['idplayer'].value = '<?php echo $k['idplayer'] ?>';
                                    document.forms['actform'].elements['sub_act_value'].value = '<?php echo PKR_DEL_PLAYER ?>';
                                    document.forms['actform'].submit();
                                } else {
                                    return false;
                                }"></td>

                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
            <tr><td colspan="<?php echo $colspan ?>" align="center">
                    <?php
                    for ($i = 1; $i <= $pages; $i++) {
                        ?>
                        <a href="javascript:document.forms['myform'].elements['page'].value='<?php echo $i ?>';document.forms['myform'].submit();">
                        <?php echo $i ?>
                        </a>&nbsp;
                        <?php
                    }
                    ?>
                </td></tr>

            <tr>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">			
                <td colspan="<?php echo $colspan ?>" align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                </td>
            </form>
        </tr>		

        </table>
        <?php
    }

    /**
     * inputModPlr
     * 
     * inputModPlr function
     * @param int $idplayer
     */
    function inputModPlr($idplayer) {
        global $plr_view, $plr_key, $plr_type;

        $query = "select * from pkr_player where idplayer=" . $idplayer;
        $rows = $GLOBALS['mydb']->select($query);
        $rows = $rows[0];

        //echo "<pre>";	
        //print_r($rows);
        //echo "</pre>";		
        ?>
        <table align="center">

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>				

            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="actform" method="get">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MOD_PLAYER ?>">
                <input type="hidden" name="sub_sub_act_value" value="<?php echo PKR_MOD ?>">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
                <input type="hidden" name="src" value="<?php echo $_REQUEST['src'] ?>">

                <?php
                foreach ($rows as $name => $value) {
                    if (in_array($name, $plr_view)) {
                        $focus = "";
                        if ($name == $plr_key)
                            $focus = "onFocus='blur()'";
                        ?>
                        <tr>
                            <td><?php echo strtoupper($name) ?></td>
                            <td><input type="text" size="<?php echo (strlen($value) + 5) ?>" name="<?php echo $name ?>" value="<?php echo $value ?>" <?php echo $focus ?>></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" value="<?php echo self::$__lang['modify_button'] ?>"></td>
                </tr>

            </form>
        </table>

        <?php ?>
        <br>

        <table align="center">
            <tr>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MANAGE_PLAYERS ?>">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
                <td colspan="<?php echo $colspan ?>" align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                </td>
            </form>
        </tr>
        </table>					
        <?php
    }

    /**
     * redirect
     * 
     * redirect function
     * @param string $case
     * @param int $time (sec)
     * @param boolean $body
     */
    function redirect($case = PKR_MANAGE_PLAYERS, $time = 0, $body = false) {
        if ($body) {
            ?>		
            <html><body>
                    <?php
                }
                ?>
                <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                    <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                    <input type="hidden" name="sub_act_value" value="<?php echo $case ?>">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
                </form>
                <?php
                if ($time == 0) {
                    ?>
                    <script language="javascript">
                        <!-- 
                    document.forms['back'].submit();
            -->
                    </script>
                    <?php
                } else {
                    ?>
                    <script language="javascript">
                        <!-- 
                    setTimeout("document.forms['back'].submit()", '<?php echo $time * 1000 ?>');
            -->
                    </script>
                    <?php
                }

                if ($body) {
                    ?>		
                </body></html>
            <?php
        }
        ?>		
        <?php
    }

    /**
     * showFilesLog
     * 
     * showFilesLog function
     * @param array $arr
     */
    function showFilesLog($arr) {
        echo "<table width='800' cellspcing='5' class='special'>";
        ?>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="myform" method="post">
            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
            <input type="hidden" name="sub_act_value" value="<?php echo PKR_SHOW_LOGS ?>">
            <input type="hidden" name="sub_sub_act_value" value="">
            <input type="hidden" name="file" value="">
            <?php
            echo "<tr>";
            echo "<td><b>Name</b></td>";
            echo "<td><b>size</b></td>";
            echo "<td><b>perm</b></td>";
            echo "<td><b>type</b></td>";
            echo "<td colspan='2'><b>time</b></td>";
            echo "<td><b>act</b></td>";
            echo "</tr>";

            $i = 0;
            foreach ($arr as $file) {
                if ($file["type"] == 'file') {
                    /* if ($i % 2 == 0)
                      echo "<tr bgcolor='#eeeeee'>";
                      else
                      echo "<tr bgcolor='#ffffff'>";
                     */
                    echo "<tr>";

                    //Name
                    echo "<td>";
                    if ($file['size'] > 0) {
                        echo "<a href=\"#\" onClick=\"document.forms['myform'].elements['file'].value='" . CONST_LOG_PATH . $file["name"] . "';document.forms['myform'].elements['sub_sub_act_value'].value='" . PKR_VIEW_LOG . "';document.forms['myform'].submit();return false;\">";
                        echo "<u>" . $file["name"] . "</u>";
                        echo "</a>";
                    } else
                        echo $file["name"];
                    echo "</td>";

                    foreach ($file as $type => $value) {
                        if ($type != 'name') {
                            echo "<td>";
                            echo $value;
                            echo "</td>";
                        }
                    }

                    echo "<td>";
                    echo "<input type='image' src='../images/del.gif' onClick=\"document.forms['myform'].elements['file'].value='" . CONST_LOG_PATH . $file["name"] . "';document.forms['myform'].elements['sub_sub_act_value'].value='" . PKR_DEL_LOG . "';document.forms['myform'].submit();\">";
                    echo "</td>";

                    echo "</tr>";
                }
                $i++;
            }
            ?>
        </form>
        <?php
        echo "</table>";
        ?>
        <br>
        <br>
        <table align="center">
            <tr>
            <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="back" method="post">
                <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                <input type="hidden" name="sub_act_value" value="<?php echo PKR_MAIN_MENU ?>">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
                <td colspan="<?php echo $colspan ?>" align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['back'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                </td>
            </form>
        </tr>
        </table>		
        <?php
    }

    /**
     * viewLog
     * 
     * viewLog function
     * @param string $file
     */
    function viewLog($file) {
        ?>
        <table border=0 width="900">
            <tr><td align="center" valign="top">

                    <table width="200" align="left">
                        <tr>
                        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="backup" method="post">
                            <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                            <input type="hidden" name="sub_act_value" value="<?php echo PKR_SHOW_LOGS ?>">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
                            <td colspan="<?php echo $colspan ?>" align="left">
                                <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['backup'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                            </td>
                        </form>
            </tr>
        </table>

        </td></tr>
        <tr><td>

                <table width="100%">
                    <tr><td align="left">
                            <pre><font face="verdana,arial" size="1">
                                <?php
                                echo readfile($file)
                                ?>
                        			</font></pre>
                        </td></tr>
                </table>

            </td></tr>
        <tr><td>

                <table width="200" align="left">
                    <tr>
                    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" name="backdw" method="post">
                        <input type="hidden" name="act_value" value="<?php echo PKR_ADMIN ?>">
                        <input type="hidden" name="sub_act_value" value="<?php echo PKR_SHOW_LOGS ?>">
                        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
                        <td colspan="<?php echo $colspan ?>" align="left">
                            <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="document.forms['backdw'].submit();">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                        </td>
                    </form>
        </tr>
        </table>

        </td></tr>
        </table>
        <?php
    }

    /**
     * credit2arr_fish
     * 
     * credit2arr_fish function
     * @param double $credit
     */
    function credit2arr_fish($credit) {
        $arrtmp = array(5000000, 1000000, 500000, 100000, 25000, 5000, 1000, 500, 100, 25, 5, 1, '0.25', '0.05', '0.01');
        $arr_fish = array();
        $mod = $credit;
        for ($i = 0; $i < count($arrtmp); $i++) {
            $div = @($mod / $arrtmp[$i]);
            if ($div == 0) {
                //echo "<br>".$arrtmp[$i];
            } else {
                $div = floor($div);
                //echo "<br>".$mod." - ".$arrtmp[$i]." = ".$div;
                $mod = $mod % $arrtmp[$i];
                $arr_fish[$i] = ceil($div);
            }
        }
        return $arr_fish;
    }

    /**
     * arrfish2image
     * 
     * arrfish2image function
     * @param array $arrfish
     */
    function arrfish2image($arrfish) {
        $strtmp = "../images/chips/chip";
        $arrtmp = array("5000000", "1000000", "500000", "100000", "25000", "5000", "1000", "500", "100", "25", "5", "1", "25c", "5c", "1c");
        $str = '';
        $str .= '<table cellspacing="0" cellpadding="0" width="1" border="0">';
        $n_arrtmp_element = 0;
        $z = 0;
        foreach ($arrfish as $k => $num) {
            $str .= '<td valign="bottom">';
            $str .= '<table cellspacing="0" cellpadding="0" border="0" width="1">';

            $n = 1;
            for ($i = $num; $i > 0; $i--) {
                $img = $strtmp . $arrtmp[$n_arrtmp_element] . ".gif";

                $str .= '<tr>';
                $str .= '<td width="1">';
                $str .= '<DIV id="f' . $z . $n . '" STYLE="position:relative; top:' . (($i - 1) * 15) . 'px; left:0px; z-index:' . (100 - $z) . '"><img src="' . $img . '"></div>';
                $str .= '</td>';
                $str .= '</tr>';

                $n++;
                $z++;
            }

            $str .= '</table>';
            $str .= '</td>';

            $n_arrtmp_element++;
        }
        $str .= '</tr>';
        $str .= '</table>';
        return $str;
    }

    /**
     * viewPlayerProfile
     * 
     * viewPlayerProfile function
     * @param array $arr
     */
    function viewPlayerProfile($arr) {
        $query = "SELECT SQL_CACHE usr, idplayer, (virtual_money-(n_credit_update*" . PKR_DEFAUL_GET_CREDIT . ")) as w FROM pkr_player WHERE confirmed=1 ORDER BY w DESC";
        $res = $GLOBALS['mydb']->special_select($query, "idplayer");

        // Insert pos field in player ranking array
        array_walk($res, 'setPos');

        $query = "SELECT usr, idplayer from pkr_player where idplayer = " . $arr['idplayer'];
        $rows = $GLOBALS['mydb']->select($query);

        // Insert pos for user on table
        array_walk($rows, 'addElement', $res);

        $mypos = $rows[0]['pos'];
        unset($res);
        unset($rows);
        ?>


        <br>
        <!--1-->
        <table width="100%" border="0" align="center" border="0">
            <tr>
                <td valign="top">

                    <!--2-->	
                    <table width="370" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">

                        <!--<tr>
                        <td colspan="2">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
                                <tr>		
                                        <td width="1"><img src="../images/site/tleft.gif" border="0"></td>	
                                        <td style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x">USER&nbsp;PROFILE:&nbsp;&nbsp;<b><?php echo strtoupper($arr['usr']) ?></b></td>
                                        <td width="1"><img src="../images/site/tright.gif" border="0"></td>
                                </tr>
                                </table>

                        </td>
                        </tr>

                        <tr><td colspan="2">&nbsp;</td></tr>-->

                        <tr>
                            <td colspan="2">

                                <!--3-->
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <!--4-->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
                                                <?php
                                                //$str = "idplayer,usr,mail,city,isc_date,virtual_money,supporter,bonus";
                                                foreach ($arr as $key => $val) {
                                                    //&& ($key != "usr")
                                                    if (($key != "supporter") && ($key != "bonus") && ($key != "virtual_money")) {
                                                        $str = "";
                                                        switch ($key) {
                                                            case "idplayer":
                                                                $type = "hidden";
                                                                $fval = "";
                                                                $fkey = "";
                                                                $str = "onFocus = 'blur()'";
                                                                break;
                                                            case "n_credit_update":
                                                                $type = "";
                                                                $fval = "";
                                                                $fkey = ""; //$key;
                                                                $str = "";
                                                                break;
                                                            case "isc_date":
                                                                $type = "text";
                                                                $fval = date("d/m/Y", $val);
                                                                $fkey = self::$__lang['profile_registered_text']; //"REGISTERED";//$key;
                                                                $str = "onFocus = 'blur()'";
                                                                break;
                                                            case "points":
                                                                $type = "text";
                                                                $fval = $val;
                                                                $fkey = self::$__lang['profile_points_text']; //"POINTS";
                                                                $str = "";
                                                                break;
                                                            case "usr":
                                                                $type = "text";
                                                                $fval = strtoupper($val);
                                                                $fkey = self::$__lang['profile_user_text']; //"USER";
                                                                $str = "";
                                                                break;
                                                            case "rank":
                                                                $type = "text";
                                                                $fval = $GLOBALS['rank'][getPlayerRank($val)];
                                                                $fkey = self::$__lang['profile_rank_text']; //"RANK";
                                                                $str = "";
                                                                break;
                                                            case "city":
                                                                $type = "text";
                                                                if (!empty($val)) {
                                                                    $fval = strtoupper($val);
                                                                } else {
                                                                    $fval = "-";
                                                                }
                                                                $fkey = self::$__lang['city']; //"RANK";
                                                                $str = "";
                                                                break;
                                                            case "bonus":
                                                                $type = "image";
                                                                $fval = $val;
                                                                $fkey = $key;
                                                                $str = "src='../images/bonus/" . $val . ".png'";
                                                                break;
                                                            case "supporter":
                                                                $type = "text";
                                                                if ($val == 1)
                                                                    $fval = "si";
                                                                else
                                                                    $fval = "no";
                                                                $fkey = $key;
                                                                $str = "onFocus = 'blur()'";
                                                                break;
                                                            default:
                                                                $fval = "";
                                                                $fkey = "";
                                                                if (!empty($val)) {
                                                                    $type = "text";
                                                                    $fval = strtoupper($val);
                                                                    $fkey = $key;
                                                                }
                                                                break;
                                                        }
                                                        if ((!empty($fkey)) || (!empty($fval))) {
                                                            ?>	
                                                            <tr>
                                                                <td width="40%">
                    <?php echo strtoupper($fkey); ?>
                                                                </td>
                                                                <td width="60%">
                                                                        <!--<input type="<?php echo $type ?>" name="<?php echo $key ?>" value="<?php echo $fval ?>" size="<?php echo strlen($val) + 2 ?>" <?php echo $str ?>>-->
                                                                    <b><?php echo $fval ?></b>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td width="40%">
        <?php echo self::$__lang['profile_ranking_text'] ?>
                                                    </td>
                                                    <td width="60%">
                                                        <b><?php echo $mypos ?></b>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td>

                                                        <?php
                                                        $supporter = $arr['supporter'];
                                                        $mybonus = $arr['bonus'];
                                                        $virtual_money = $arr['virtual_money'];
                                                        $ncost = count($this->cost);

                                                        $got = $arr['n_credit_update'] * PKR_DEFAUL_GET_CREDIT;
                                                        $repayment = $arr['n_credit_update'] * 0.50;
                                                        $got2 = $got / 2;
                                                        $repayment2 = $repayment / 2;
                                                        ?>				

                                            </table>
                                            <!--4-->

                                        </td><td align="center" valign="top">

                                            <table width="1" border="0">
                                                <tr><td>
                                                        <div style="position:relative;" id="fishs"><?php echo self::$__lang['loading'] ?></div>
                                                    </td></tr>
                                                <tr><td align="center"><?php echo self::$__lang['profile_your_pocket'] ?> <br><b><?php echo number_format($virtual_money, 2, ',', '.') ?></b><?php echo PKR_CURRENCY_SYMBOL ?>
                                                    </td></tr>
                                                <tr><td align="center"><?php echo self::$__lang['profile_money_lost'] ?> <br><b><?php echo number_format($got, 2, ',', '.') ?></b><?php echo PKR_CURRENCY_SYMBOL ?>
                                                    </td></tr>							
                                            </table>

                                            <script language="javascript">
                                                <!--
                                                    function setFish() {
                                                    var mydiv = document.getElementById('fishs');
                                                    mydiv.innerHTML = '<?php echo $this->arrfish2image($this->credit2arr_fish($virtual_money)) ?>';
                                                }
                                                window.onload = setFish;
        -->
                                            </script>

                                        </td>
                                    </tr>
                                </table>
                                <!--3-->

                            </td>
                        </tr>				

                        <?php
                        if ($arr['n_credit_update'] > 1) {
                            ?>				

                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>					

                            <tr>
                                <td colspan="2"><?php echo self::$__lang['profile_repay'] ?></td>
                            </tr>										

                            <tr>
                            <form action="https://www.paypal.com/cgi-bin/webscr" name="solve" target="_blank" method="post">
                                <input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT ?>">
                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="no_shipping" value="1">
                                <input type="hidden" name="bn" value="PP-BuyNowBF">
                                <input type="hidden" name="lc" value="PL">
                                <input type="hidden" name="no_note" value="1">
                                <input type="hidden" name="return" value="<?php echo _myurl ?>">
                                <input type="hidden" name="amount" value="<?php echo str_replace(",", ".", $repayment) ?>">
                                <input type="hidden" name="currency_code" value="EUR">
                                <input type="hidden" name="item_name" value="Dotacja flashpoker solve <?php echo $got ?><?php echo PKR_CURRENCY_SYMBOL ?> gracz #<?php echo $arr['idplayer'] ?># <?php echo $arr['usr'] ?> <?php echo $arr['mail'] ?>">
                                <input type="hidden" name="item_number" value="<?php echo 'totalsolve' ?>">		
                                <td colspan="2"><a href="#" title="<?php echo self::$__lang['profile_repay_all'] ?>" onClick="document.forms['solve'].submit()"><u><?php echo self::$__lang['profile_repay_all'] ?> <b><?php echo $repayment ?><?php echo PKR_CURRENCY_SYMBOL ?></b></u></a> *</td>
                            </form>
                </tr>			

                <tr>
                <form action="https://www.paypal.com/cgi-bin/webscr" name="partialsolve" target="_blank" method="post">
                    <input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT ?>">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="bn" value="PP-BuyNowBF">
                    <input type="hidden" name="lc" value="PL">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="return" value="<?php echo _myurl ?>">
                    <input type="hidden" name="amount" value="<?php echo str_replace(",", ".", $repayment2) ?>">
                    <input type="hidden" name="currency_code" value="EUR">
                    <input type="hidden" name="item_name" value="Dotacja flashpoker solve <?php echo $got2 ?><?php echo PKR_CURRENCY_SYMBOL ?> gracz #<?php echo $arr['idplayer'] ?># <?php echo $arr['usr'] ?> <?php echo $arr['mail'] ?>">
                    <input type="hidden" name="item_number" value="<?php echo 'partialsolve' ?>">		
                    <td colspan="2"><a href="#" title="<?php echo self::$__lang['profile_repay_half'] ?>" onClick="document.forms['partialsolve'].submit()"><u><?php echo self::$__lang['profile_repay_half'] ?> <b><?php echo $repayment2 ?><?php echo PKR_CURRENCY_SYMBOL ?></b></u></a> *</td>
                </form>
            </tr>											

            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>					

            <tr>
                <td colspan="2">*+1 <?php echo self::$__lang['bonus'] ?> E +1000<?php echo PKR_CURRENCY_SYMBOL ?></td>
            </tr>		

        <?php } ?>			

        <tr><td colspan="2">

                <?php
                if ($supporter == 0) {
                    ?>
                    <?php echo self::$__lang['not_supporter'] ?>
                    <?php
                } else {
                    ?>
                    <?php echo self::$__lang['current_supporter_level'] ?><b><?php echo $supporter ?></b>
                    <?php
                }
                ?>					

            </td>
        </tr>					
        </table>
        <!--2-->

        </td>
        </tr>
        </table>
        <!--1-->

        <br><br>
        <table border="0" align="center" width="100%">
            <tr>
                <td>&nbsp;</td>
                <?php
                for ($i = 1; $i <= $ncost; $i++) {
                    ?>

                <form action="https://www.paypal.com/cgi-bin/webscr" name="payimg<?php echo $i ?>" target="_blank" method="post">
                    <input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT ?>">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="bn" value="PP-BuyNowBF">
                    <input type="hidden" name="lc" value="PL">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="return" value="<?php echo _myurl ?>">
                    <input type="hidden" name="amount" value="<?php echo str_replace(",", ".", $this->cost[$i]) ?>">
                    <input type="hidden" name="currency_code" value="EUR">
                    <input type="hidden" name="item_name" value="Dotacja flashpoker +<?php echo $this->bonus[$i] ?><?php echo PKR_CURRENCY_SYMBOL ?> gracz #<?php echo $arr['idplayer'] ?># <?php echo $arr['usr'] ?> <?php echo $arr['mail'] ?>">
                    <input type="hidden" name="item_number" value="<?php echo $i ?>">			
                    <td><a href="#" onClick="document.forms['payimg<?php echo $i ?>'].submit()"><img src="../images/bonus/<?php echo $i ?>.png" border="0" title="  <?php echo $this->cost[$i] ?>�"></a></td>
                </form>		

                <?php
            }
            ?>
        </tr>

        <tr bgcolor="#ddddee">
            <td><?php echo self::$__lang['donate'] ?></td>
            <?php
            for ($i = 1; $i <= $ncost; $i++) {
                ?>
            <form action="https://www.paypal.com/cgi-bin/webscr" name="pay<?php echo $i ?>" target="_blank" method="post">
                <input type="hidden" name="business" value="<?php echo PAYPAL_ACCOUNT ?>">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="bn" value="PP-BuyNowBF">
                <input type="hidden" name="lc" value="PL">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="return" value="<?php echo _myurl ?>">
                <input type="hidden" name="amount" value="<?php echo str_replace(",", ".", $this->cost[$i]) ?>">
                <input type="hidden" name="currency_code" value="EUR">
                <input type="hidden" name="item_name" value="Dotacja flashpoker +<?php echo $this->bonus[$i] ?><?php echo PKR_CURRENCY_SYMBOL ?> gracz #<?php echo $arr['idplayer'] ?># <?php echo $arr['usr'] ?> <?php echo $arr['mail'] ?>">
                <input type="hidden" name="item_number" value="<?php echo $i ?>">			
                <td><a href="#" title=" " onClick="document.forms['pay<?php echo $i ?>'].submit()"><u><?php echo $this->cost[$i] . PKR_CURRENCY_SYMBOL ?></u></td>
            </form>
            <?php
        }
        ?>
        </tr>

        <tr>
            <td><b><?php echo self::$__lang['bonus'] ?></b></td>
            <?php
            for ($i = 1; $i <= $ncost; $i++) {
                ?>
                <td>+<b><?php echo $this->bonus[$i] / 1000 ?>K</b><?php echo PKR_CURRENCY_SYMBOL ?></td>
                <?php
            }
            ?>				
        </tr>

        <tr>
            <td><?php echo self::$__lang['curr'] ?></td>
            <?php
            for ($i = 1; $i <= $ncost; $i++) {
                ?><td><?php
                    if ($i == $mybonus) {
                        ?>
                        &nbsp;&nbsp;&nbsp;<b><font size="3">^</font></b>
                        <?php
                    } else {
                        ?>
                        &nbsp;
                        <?php
                    }
                    ?></td><?php
            }
            ?>				
        </tr>				
        </table>

        <br><br>

        <table>
            <tr>
                <td width="90%">
        <?php echo self::$__lang['profile_info_text'] ?>
                </td>
                <td valign="middle">
                    <img src="../images/site/paypalVerified.png">
                </td>
            </tr>
        </table>

        <br>

        <table align="center">
            <tr>
                <td colspan="6" align="center">
                    <input type="button" value="<?php echo self::$__lang['back_button'] ?>" onClick="window.location = 'index.php';">&nbsp;<input type="button" value="<?php echo self::$__lang['logout_button'] ?>" onClick="window.location = 'logout.php';">
                </td>
            </tr>		
        </table>		
        <?php
    }

    /**
     * viewUserProfile
     * 
     * viewUserProfile function
     * @param array $arr
     */
    function viewUserProfile($arr) {
        $query = "SELECT SQL_CACHE usr, idplayer, (virtual_money-(n_credit_update*" . PKR_DEFAUL_GET_CREDIT . ")) as w FROM pkr_player WHERE confirmed=1 ORDER BY w DESC";
        $res = $GLOBALS['mydb']->special_select($query, "idplayer");

        // Insert pos field in player ranking array
        array_walk($res, 'setPos');

        $query = "SELECT usr, idplayer from pkr_player where idplayer = " . $arr['idplayer'];
        $rows = $GLOBALS['mydb']->select($query);

        // Insert pos for user on table
        array_walk($rows, 'addElement', $res);

        $mypos = $rows[0]['pos'];
        unset($res);
        unset($rows);
        ?>

        <br>
        <!--1-->
        <table width="99%" border="0" align="center" border="0">
            <tr>
                <td valign="top">

                    <!--2-->	
                    <table width="370" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">

                        <!--<tr>
                        <td colspan="2">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
                                <tr>		
                                        <td width="1"><img src="../images/site/tleft.gif" border="0"></td>	
                                        <td style="height:8px; font-size: 12px; font-weight: bold; color: white; background-image: url(../images/site/tmiddle.gif);background-repeat: repeat-x">USER&nbsp;PROFILE:&nbsp;&nbsp;<b><?php echo strtoupper($arr['usr']) ?></b></td>
                                        <td width="1"><img src="../images/site/tright.gif" border="0"></td>
                                </tr>
                                </table>

                        </td>
                        </tr>

                        <tr><td colspan="2">&nbsp;</td></tr>-->

                        <tr>
                            <td colspan="2">		

                                <!--3-->
                                <table width="100%">
                                    <tr>
                                        <td width="50%">
                                            <!--4-->
                                            <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000">
                                                <?php
                                                //$str = "idplayer,usr,mail,city,isc_date,virtual_money,supporter,bonus";
                                                foreach ($arr as $key => $val) {
                                                    //&& ($key != "usr")
                                                    if (($key != "supporter") && ($key != "bonus") && ($key != "virtual_money")) {
                                                        $str = "";
                                                        switch ($key) {
                                                            case "idplayer":
                                                                $type = "hidden";
                                                                $fval = "";
                                                                $fkey = "";
                                                                $str = "onFocus = 'blur()'";
                                                                break;
                                                            case "n_credit_update":
                                                                $type = "";
                                                                $fval = "";
                                                                $fkey = ""; //$key;
                                                                $str = "";
                                                                break;
                                                            case "isc_date":
                                                                $type = "text";
                                                                $fval = date("d/m/Y", $val);
                                                                $fkey = self::$__lang['profile_registered_text']; //"REGISTERED";//$key;
                                                                $str = "onFocus = 'blur()'";
                                                                break;
                                                            case "points":
                                                                $type = "text";
                                                                $fval = $val;
                                                                $fkey = self::$__lang['profile_points_text']; //"POINTS";
                                                                $str = "";
                                                                break;
                                                            case "usr":
                                                                $type = "text";
                                                                $fval = strtoupper($val);
                                                                $fkey = self::$__lang['profile_user_text']; //"USER";
                                                                $str = "";
                                                                break;
                                                            case "rank":
                                                                $type = "text";
                                                                $fval = $GLOBALS['rank'][getPlayerRank($val)];
                                                                $fkey = self::$__lang['profile_rank_text']; //"RANK";
                                                                $str = "";
                                                                break;
                                                            case "city":
                                                                $type = "text";
                                                                if (!empty($val)) {
                                                                    $fval = strtoupper($val);
                                                                } else {
                                                                    $fval = "-";
                                                                }
                                                                $fkey = self::$__lang['city']; //"RANK";
                                                                $str = "";
                                                                break;
                                                            case "bonus":
                                                                $type = "image";
                                                                $fval = $val;
                                                                $fkey = $key;
                                                                $str = "src='../images/bonus/" . $val . ".png'";
                                                                break;
                                                            case "supporter":
                                                                $type = "text";
                                                                if ($val == 1)
                                                                    $fval = "si";
                                                                else
                                                                    $fval = "no";
                                                                $fkey = $key;
                                                                $str = "onFocus = 'blur()'";
                                                                break;
                                                            default:
                                                                $fval = "";
                                                                $fkey = "";
                                                                if (!empty($val)) {
                                                                    $type = "text";
                                                                    $fval = strtoupper($val);
                                                                    $fkey = $key;
                                                                }
                                                                break;
                                                        }
                                                        if ((!empty($fkey)) || (!empty($fval))) {
                                                            ?>	
                                                            <tr>
                                                                <td width="50%">
                    <?php echo strtoupper($fkey); ?>
                                                                </td>
                                                                <td width="50%">
                                                                        <!--<input type="<?php echo $type ?>" name="<?php echo $key ?>" value="<?php echo $fval ?>" size="<?php echo strlen($val) + 2 ?>" <?php echo $str ?>>-->
                                                                    <b><?php echo $fval ?></b>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td width="40%">
        <?php echo self::$__lang['profile_ranking_text'] ?>
                                                    </td>
                                                    <td width="60%">
                                                        <b><?php echo $mypos ?></b>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td>

                                                        <?php
                                                        $supporter = $arr['supporter'];
                                                        $mybonus = $arr['bonus'];
                                                        $virtual_money = $arr['virtual_money'];
                                                        $ncost = count($this->cost);

                                                        $got = $arr['n_credit_update'] * PKR_DEFAUL_GET_CREDIT;
                                                        $repayment = $arr['n_credit_update'] * 0.50;
                                                        $got2 = $got / 2;
                                                        $repayment2 = $repayment / 2;
                                                        ?>				

                                            </table>
                                            <!--4-->

                                        </td><td align="center" valign="top">

                                            <table width="1" border="0">
                                                <tr><td>
                                                        <div style="position:relative;" id="fishs">loading...</div>							
                                                    </td></tr>
                                                <tr><td align="center"><?php echo self::$__lang['profile_pocket'] ?> <br><b><?php echo number_format($virtual_money, 2, ',', '.') ?></b><?php echo PKR_CURRENCY_SYMBOL ?>
                                                    </td></tr>
                                                <tr><td align="center"><?php echo self::$__lang['profile_money_lost'] ?> <br><b><?php echo number_format($got, 2, ',', '.') ?></b><?php echo PKR_CURRENCY_SYMBOL ?>
                                                    </td></tr>							
                                            </table>
                                            <script language="javascript">
                                                <!--
                                                    function setFish() {
                                                    var mydiv = document.getElementById('fishs');
                                                    mydiv.innerHTML = '<?php echo $this->arrfish2image($this->credit2arr_fish($virtual_money)) ?>';
                                                }
                                                window.onload = setFish;
        -->
                                            </script>

                                        </td>
                                    </tr>
                                </table>
                                <!--3-->
                            </td>
                        </tr>
                    </table>
                    <!--2-->

                </td>
            </tr>
        </table>
        <!--1-->
        <br><br><br><br><br>	
        <br><br><br><br><br>
        <br><br><br>		
        <?php
    }

    /**
     * getPokerInYourSite
     * 
     * getPokerInYourSite function
     */
    function getPokerInYourSite() {
        $uri = str_replace("index/", "yourpoker/", $_SERVER['REQUEST_URI']);
        $url = "http://" . $_SERVER['HTTP_HOST'] . $uri;
        ?>
            <?php echo self::$__lang['yourpoker_top'] ?>
        <textarea rows="10" cols="100">
                        		&lt;center&gt;
                        		&lt;iframe id="poker" src="<?php echo $url ?>" style="background-color: transparent;" allowtransparency="allowtransparency" frameborder="0" marginheight="0" marginwidth="0" width="805" height="479"&gt;&lt;/iframe&gt;
                        		&lt;/center&gt;
        </textarea>
        <?php echo self::$__lang['yourpoker_bottom'] ?>
        <?php
    }

    /**
     * getBuy
     * 
     * getBuy function
     */
    function getBuy() {
        ?>
        <table width="899" align="center" cellpadding="2">
            <tr>
                <td>
        <?php echo self::$__lang['buy_text'] ?>		
                </td>
            </tr>
        </table>
        <?php
    }

}
?>