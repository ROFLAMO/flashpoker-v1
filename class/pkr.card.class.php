<?php

//c cuori
//q quadri
//f fiori
//p picche
require("pkr.checkptg.class.php");

/**
 * Card Class 
 *
 * Class that manages card information
 * Extends Post Class
 * 
 */
class Card {

    var $deal = array(
        "1:c",
        "2:c",
        "3:c",
        "4:c",
        "5:c",
        "6:c",
        "7:c",
        "8:c",
        "9:c",
        "10:c",
        "J:c",
        "Q:c",
        "K:c",
        "1:q",
        "2:q",
        "3:q",
        "4:q",
        "5:q",
        "6:q",
        "7:q",
        "8:q",
        "9:q",
        "10:q",
        "J:q",
        "Q:q",
        "K:q",
        "1:f",
        "2:f",
        "3:f",
        "4:f",
        "5:f",
        "6:f",
        "7:f",
        "8:f",
        "9:f",
        "10:f",
        "J:f",
        "Q:f",
        "K:f",
        "1:p",
        "2:p",
        "3:p",
        "4:p",
        "5:p",
        "6:p",
        "7:p",
        "8:p",
        "9:p",
        "10:p",
        "J:p",
        "Q:p",
        "K:p"
    );
    var $hand_ranks = Array(
        PKR_HIGHCARD => 0,
        PKR_PAIR => 1,
        PKR_TWOPAIR => 2,
        PKR_THREEOFAKIND => 3,
        PKR_STRAIGHT => 4,
        PKR_FLUSH => 5,
        PKR_FULLHOUSE => 6,
        PKR_FOUROFAKIND => 7,
        PKR_STRAIGHTFLUSH => 8,
        PKR_ROYALFLUSH => 9
    );
    var $combinations = Array(
        Array(0, 1, 2),
        Array(0, 1, 3),
        Array(0, 1, 4),
        Array(1, 2, 3),
        Array(1, 2, 4),
        Array(2, 3, 4),
        Array(0, 2, 3),
        Array(0, 3, 4),
        Array(1, 3, 4),
        Array(0, 2, 4), // 9		
        Array(1, 2, 3, 4),
        Array(0, 2, 3, 4),
        Array(0, 1, 3, 4),
        Array(0, 1, 2, 4),
        Array(0, 1, 2, 3), // 14						
        Array(1, 2, 3, 4),
        Array(0, 2, 3, 4),
        Array(0, 1, 3, 4),
        Array(0, 1, 2, 4),
        Array(0, 1, 2, 3), // 19
        Array(0, 1, 2, 3, 4) // 20				
    );
    var $cards = null;

    /**
     * Constructor
     * 
     * Do nothing
     *
     */
    function Card() {
        
    }

    /**
     * Set Cards
     * 
     * Set current Cards
     *
     * @param array $cards 	
     */
    function setCards($cards) {
        $this->cards = $cards;
    }

    /**
     * Set Deal
     * 
     * Set current Deal
     *
     * @param object $deal 
     */
    function setDeal($deal) {
        $this->deal = $deal;
    }

    /**
     * Get Last Game Card
     * 
     * Get last cards of last deal. Used to do shuffle
     *
     * @return array
     */
    function getLastGameCard() {
        if (!PKR_GET_LAST_DEAL)
            return null;

        $query = "select CONCAT(number,':',seed) as cards from pkr_card where game=(select idgame from pkr_game where idtable=" . $this->curr_table . " and end=1 and (select count(*) as n from pkr_card where game=idgame)=52 order by idgame desc limit 1) order by seq";
        $temp = $GLOBALS['mydb']->select($query);

        if (!isset($temp))
            return null;

        $n = count($temp);

        $lcards = array($n);
        for ($i = 0; $i < $n; $i++) {
            $lcards[$i] = $temp[$i]["cards"];
        }
        unset($temp);

        return $lcards;
    }

    /**
     * Pic to Number
     * 
     * Transform picture cards to number. For example J -> 11 
     *
     * @param string $card 
     */
    function pic2Number($card) {
        switch ($card) {
            case 1:
                return 14;
                break;
            case 'J':
                return 11;
                break;
            case 'Q';
                return 12;
                break;
            case 'K';
                return 13;
                break;
            default:
                return $card;
                break;
        }
    }

    /**
     * Number to Pic
     * 
     * Transform Number cards to pic. For example 1 -> A
     *
     * @param string|int $card 
     */
    function number2Pic($card) {
        switch ($card) {
            case 11:
                return 'J';
                break;
            case 12;
                return 'Q';
                break;
            case 13;
                return 'K';
                break;
            case 1:
            case 14;
                return 'A';
                break;
            default:
                return $card;
                break;
        }
    }

    /**
     * Shuffle array
     * 
     * Do shuffle of array of cards
     *
     * @param array $input_array
     * @return array
     */
    function shuffle_assoc($input_array) {
        //$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"DB","DEAL BEFORE SHUFFLE",join(",",$input_array));

        srand((float) microtime() * 1000000);
        shuffle($input_array);

        $i = 0;
        while (list(, $value) = each($input_array)) {
            $array[$i] = $value;
            $i++;
        }

        //$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"DB","DEAL AFTER SHUFFLE",join(",",$array));

        return $array;
    }

    /**
     * Create Deal
     * 
     * Create Deal after doing shuffle and insert it on database
     */
    function createDeal() {
        $deal = $this->shuffle_assoc($this->deal);

        $query = "delete from pkr_card where game=?";
        $params = array($this->curr_game);
        $GLOBALS['mydb']->delete($query, $params);

        $i = 1;
        foreach ($deal as $k => $v) {
            $card = split(':', $v);
            $query = "INSERT INTO pkr_card (game, seq, number, seed) VALUES (?, ?, ?, ?)";
            $params = array($this->curr_game, $i, $card[0], $card[1]);
            $GLOBALS['mydb']->insert($query, $params);
            $i++;
        }
    }

    /**
     * Get Cards
     * 
     * Get Cards from database
     *
     * @return array
     */
    function getCards() {
        $query = "select * from pkr_card where game=" . $this->curr_game . " order by seq";
        $rows = $GLOBALS['mydb']->select($query);
        return $rows;
    }

    /**
     * Get Card
     * 
     * Get Player cards (2 for holdem) of current game and current table
     *
     * @return array
     */
    function getCard() {
        //$query = "select number,card,seed,seat,s.player as player from pkr_dealer d inner join pkr_seat s on d.seat=s.seat_number where s.player=".$this->curr_player." and game=".$this->curr_game." and d.idtable=".$this->curr_table." and s.status=".PLAYING." order by number";
        $query = "select number,card,seed,seat,player from pkr_dealer where player=" . $this->curr_player . " and game=" . $this->curr_game . " and idtable=" . $this->curr_table . " and player in (select player from pkr_seat where status=" . PLAYING . ") order by number";
        $rows = $GLOBALS['mydb']->select($query);
        return $rows;
    }

    /**
     * Get Remain Deal
     * 
     * Get array of remain cards in last deal of current game of current table
     *
     * @return array
     */
    function getRemainDeal() {
        $query = "select * from pkr_card c where game=" . $this->curr_game . " and ((number,seed) not in (select card,seed from pkr_dealer where game=" . $this->curr_game . " order by seat)) order by seq limit 15";
        $rows = $GLOBALS['mydb']->select($query);
        return $rows;
    }

    /**
     * Burning
     * 
     * Burning a card from deal.
     *
     * @param array &$mydeal
     */
    function Burning(&$mydeal) {
        //BURNING
        $count = 0;
        $number = $mydeal[$count]["number"];
        $seed = $mydeal[$count]["seed"];
        $this->giveCard(BURNING_SEAT, BOARD_PLAYER, $number, $seed, 1);
        unset($mydeal[0]);
    }

    /**
     * Get Board Cards
     * 
     * Get Cards that are on table (used on type game as holdem)
     *
     * @return array
     */
    function getBoardCards() {
        $query = "select * from pkr_dealer where idtable=" . $this->curr_table . " and game=" . $this->curr_game . " and seat=" . BOARD . " order by number";
        $rows = $GLOBALS['mydb']->select($query);
        return $rows;
    }

    /**
     * Set Best Five
     * 
     * Check the best 5 cards of remain cards
     *
     * @param int $ptg
     * @param array $remaincards
     * @return array
     */
    function setBestFive($ptg, $remaincards) {
        $n = 0;

        $res_arr = $ptg;

        if (count($ptg) > 0)
            $n = count($ptg) - 1;

        foreach ($remaincards as $k) {
            $n++;
            if ($n >= 5)
                break;

            $res_arr[$n][$k["card"]] = $k["seed"];
        }

        usort($res_arr, by_key);

        return $res_arr;
    }

    /**
     * Get Remain Cards
     * 
     * Get ranks, player cards and board cards and calculate remain cards
     *
     * @param array $arr_rank
     * @param array $my_plr_cards
     * @param array $b_cards
     * @return array
     */
    function getRemainCards($arr_rank, $my_plr_cards, $b_cards) {
        $res_arr = array();

        $ele_rank = array();
        for ($i = 0; $i < 5; $i++) {
            if (isset($arr_rank[$i])) {
                $v = key($arr_rank[$i]);
                $w = $arr_rank[$i][key($arr_rank[$i])];
                array_push($ele_rank, $v . "," . $w);
            }
        }

        $ele_own_cards = array();
        $c_my_plr_cards = count($my_plr_cards);
        for ($i = 0; $i < $c_my_plr_cards; $i++) {
            $card = $my_plr_cards[$i]["card"];
            $card = $this->pic2Number($card);
            //if ($card == 1) $card = 14;			
            array_push($ele_own_cards, $card . "," . $my_plr_cards[$i]["seed"]);
        }

        $ele_b_cards = array();
        $c_b_cards = count($b_cards);
        for ($i = 0; $i < $c_b_cards; $i++) {
            $card = $b_cards[$i]["card"];
            $card = $this->pic2Number($card);
            //if ($card == 1) $card = 14;
            array_push($ele_b_cards, $card . "," . $b_cards[$i]["seed"]);
        }

        $arr1 = array_diff($ele_own_cards, $ele_rank);
        $arr2 = array_diff($ele_b_cards, $ele_rank);

        $res_arr = array_merge($arr1, $arr2); //array_$arr1 + $arr2;		

        unset($ele_rank);
        unset($ele_own_cards);
        unset($ele_b_cards);
        unset($arr1);
        unset($arr2);

        $n = 0;
        $c_res_arr = count($res_arr);
        for ($i = 0; $i < $c_res_arr; $i++) {
            list($card, $seed) = split(',', $res_arr[$i]);
            //if ($card == 1) $card = 14;
            $tmp[$n][$card] = $seed;

            $n++;
        }
        $res_arr = $tmp;
        unset($tmp);

        usort($res_arr, by_key);

        $res_arr = array_slice($res_arr, 0, 5);

        $n = 0;
        foreach ($res_arr as $k) {
            foreach ($k as $card => $value) {
                $tmp[$n]["card"] = $card;
                $tmp[$n]["seed"] = $seed;

                $n++;
                if ($n > 4)
                    break;
            }
        }
        $res_arr = $tmp;
        unset($tmp);

        return $res_arr;
    }

    /**
     * Get Max Key and Slave
     * 
     * Calculate Max in associative array
     *
     * @param array $arr
     * @return array
     */
    function getMax_C_S($arr) {
        if (!isset($arr))
            return 0;

        $c_result[key($arr[0])] = $arr[0][key($arr[0])];
        return $c_result;
    }

    /**
     * Get Best Hand
     * 
     * Calculate the best hand on current game and current table.
     * Use CheckPtg Class
     *
     * @return array
     */
    function getBestHand() {
        $checkptg = new CheckPtg($this->cards);

        $var = $checkptg->isRoyalFlush();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isStraightFlush();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isFourOfAKind();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        // Non mi serve fare Usort
        $var = $checkptg->isFullHouse();
        //usort($var["ptg"], by_key);	
        if ($var["bool"])
            return $var;

        $var = $checkptg->isFlush();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isStraight();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isThreeOfAKind();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isTwoPair();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isPair();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;

        $var = $checkptg->isHighCard();
        usort($var["ptg"], by_key);
        if ($var["bool"])
            return $var;
    }

}

?>