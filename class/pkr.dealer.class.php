<?php

require("../class/pkr.card.class.php");

/**
 * Dealer Class 
 *
 * Class that Manage Cards and Deal on database
 * Extends Card Class
 * 
 */
class Dealer extends Card {

    var $curr_table;
    var $curr_game;
    var $curr_player;

    /**
     * Constructor
     * 
     * set current idtable, current idgame and current idplayer
     */
    function Dealer($idtable, $idgame, $idplayer) {
        $this->curr_table = $idtable;
        $this->curr_game = $idgame;
        $this->curr_player = $idplayer;
    }

    /**
     * Update Card
     * 
     * Change card and seed and update it on database
     *
     * @param string $idtable
     * @param string $idgame
     * @param string $idplayer
     * @param string $seat
     * @param string $new_card 
     * @param string $new_seed
     * @param string $card
     * @param string $seed
     */
    function updateCard($idtable, $idgame, $idplayer, $seat, $new_card, $new_seed, $card, $seed) {
        $query = "update pkr_dealer set card = ?, seed = ? where idtable = ? and game = ? and player = ? and seat = ? and card = ? and seed = ?";
        $params = array($new_card, $new_seed, $idtable, $idgame, $idplayer, $seat, $card, $seed);
        $GLOBALS['mydb']->update($query, $params);
    }

    /**
     * Give Card
     * 
     * Give card to a player or set board (used on holdem game)
     *
     * @param string $seat
     * @param string $player
     * @param string $card
     * @param string $seed
     * @param string $number 
     */
    function giveCard($seat, $player, $card, $seed, $number) {
        if (isset($this->curr_game)) {
            $query = "INSERT INTO pkr_dealer (idtable, game, seat, player, card, seed, number) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $params = array($this->curr_table, $this->curr_game, $seat, $player, $card, $seed, $number);
            $GLOBALS['mydb']->insert($query, $params);
        }
    }

    /**
     * Get Player Cards
     * 
     * Get Player Cards
     *
     * @param int $npot
     * @return array
     */
    function getPlayerCards($npot) {
        if (isset($this->curr_game)) {
            $query = "select card,seed,seat,player from pkr_dealer where idtable=" . $this->curr_table . " and game=" . $this->curr_game . " and seat not in (select seat from pkr_game_fold where idtable=" . $this->curr_table . " and game=" . $this->curr_game . ") and seat in (select distinct(seat) from pkr_typepost where idtable=" . $this->curr_table . " and player in (select player from pkr_seat where idtable=" . $this->curr_table . " and status=" . PLAYING . ") and game=" . $this->curr_game . " and number=" . $npot . ") order by seat,number";
            $cards = $GLOBALS['mydb']->select($query);
            return $cards;
        } else
            return null;
    }

}

?>