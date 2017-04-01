<?php

require("../class/pkr.subhand.class.php");

/**
 * Hand Class 
 *
 * Class that Manage Hand
 * Extends SubHand Class
 * 
 */
class Hand extends Subhand {

    var $curr_hand;
    var $curr_type_hand;
    var $type_hands = array();
    var $num_type_hands = array();

    /**
     * Constructor
     * 
     * do nothing
     */
    function Hand() {
        
    }

    /**
     * Get Last Data Hand
     * 
     * Get Last Data Hand
     *
     * @return array
     */
    function getLastDataHand() {
        if (isset($this->curr_game)) {
            // Prendo l'ultima mano !	
            $query = "select * from pkr_hand where game=" . $this->curr_game . " order by idhand desc limit 1";
            $val = $GLOBALS['mydb']->select($query);
            $val = $val[0];
            return $val;
        }
    }

    /**
     * Create Hand
     * 
     * Create a new Hand and return last inserted id
     *
     * @param string $type_hand
     * @return int
     */ function createHand($type_hand) {
        if (isset($this->curr_game)) {
            $query = "insert into pkr_hand (idtable, game, type_hand) VALUES (?, ?, ?)";
            $params = array($this->curr_table, $this->curr_game, $type_hand);
            $GLOBALS['mydb']->insert($query, $params);
            return $GLOBALS['mydb']->getlastinsertid();
        }
    }

    /**
     * Create New Hand and SubHand
     * 
     * Create New Hand and SubHand
     *
     * @param string $next_type_hand
     * @param string $next_type_subhand
     * @param int $player
     * @param int $seat
     */
    function goCreateNewHand($next_type_hand, $next_type_subhand, $player, $seat) {
        $this->curr_hand = $this->createHand($next_type_hand);
        //$this->curr_hand = $this->getLastHand();
        $this->createSubHand($player, $seat, $next_type_subhand);
    }

    /**
     * Create New Hand and SubHand
     * 
     * Create New Hand and SubHand related by a winner
     *
     * @param string $next_type_hand
     * @param string $next_type_subhand
     * @param int $win_player
     * @param int $win_seat
     */
    function goCreateNewHandWin($next_type_hand, $next_type_subhand, $win_player, $win_seat) {
        $this->curr_hand = $this->createHand($next_type_hand);
        //$this->curr_hand = $this->getLastHand();
        $this->createSubHand($win_player, $win_seat, $next_type_subhand);
    }

    /**
     * Get Last Hand
     * 
     * Get Last Hand
     *
     * @return int
     */
    function getLastHand() {
        if (isset($this->curr_game)) {
            //$query = "select idhand from pkr_hand where game=".$this->curr_game." order by idhand desc limit 1";
            $query = "select max(idhand) as idhand from pkr_hand where game=" . $this->curr_game;
            $lastid = $GLOBALS['mydb']->select($query);
            $lastid = $lastid[0]['idhand'];
            return $lastid;
        }
    }

    /**
     * Get Type Hand
     * 
     * Get Type Hand
     *
     * @return string
     */
    function getTypeHand() {
        if (isset($this->curr_hand)) {
            $query = "select type_hand from pkr_hand where idhand=" . $this->curr_hand;
            $type = $GLOBALS['mydb']->select($query);
            $type = $type[0]['type_hand'];
            return $type;
        }
    }

}

?>