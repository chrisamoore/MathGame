<?php
    /**
     * @author    Christopher A. Moore <chris@camdesigns.net>
     * @date      12/20/13
     * @copyright CAMDesigns 2013
     */

    namespace Moore\Game;

    /**
     * Class Game
     *  * @package Moore\Game
     */
    class Game {
        public $id;

        /**
         * @var
         */
        private $min;
        /**
         * @var
         */
        private $max;
        /**
         * @var
         */
        private $number;
        /**
         * @var array
         */
        private $options = [];
        /**
         * @var array
         */
        private $shuffled = [];

        /**
         * @param $min
         * @param $max
         */
        public function __construct($min, $max) {
            $this->setMin ($min);
            $this->setMax ($max);
        }

        /**
         * @param mixed $id
         *
         * @return Game
         */
        public function setId($id) {
            $this->id = $id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getId() {
            return $this->id;
        }

        /**
         * @param mixed $max
         *
         * @return Game
         */
        public function setMax($max) {
            $this->max = $max;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMax() {
            return $this->max;
        }

        /**
         * @param mixed $min
         *
         * @return Game
         */
        public function setMin($min) {
            $this->min = $min;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getMin() {
            return $this->min;
        }

        /**
         * @param mixed $number
         *
         * @return Game
         */
        public function setNumber($number) {
            $this->number = $number;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getNumber() {
            return $this->number;
        }

        /**
         * @param int|\Moore\Game\int $option
         *
         * @internal param array $options
         *
         * @return Game
         */
        public function addOption($option) {
            array_push ($this->options, $option);

            return $this;
        }

        /**
         * @return array
         */
        public function getOptions() {
            return $this->options;
        }

        /**
         * @param array $shuffled
         *
         * @return Game
         */
        public function setShuffled(array $shuffled) {
            $this->shuffled = $shuffled;

            return $this;
        }

        /**
         * @return array
         */
        public function getShuffled() {
            return $this->shuffled;
        }

        /**
         * @name generateNumber
         * @description
         * @return int
         */
        public function generateNumber() {
            return mt_rand($this->min, $this->max);
        }

        /**
         * @name generateOptions
         * @description
         */
        public function generateOptions() {
            if (count ($this->options) >= 3) {
                return;
            }

            $number = $this->generateNumber ();
            if (!in_array ($number, $this->options) && $number !== $this->number) {
                $this->addOption ($number);
            }

            $this->generateOptions ();
        }

        /**
         * @name shuffle
         * @description
         * @return array
         */
        public function shuffle() {
            $elements = $this->options;
            array_push ($elements, $this->getNumber ());
            shuffle ($elements);
            $choice = 'a';
            foreach ($elements as $key => $element) {
                $elements[$choice] = $element;
                unset($elements[$key]);
                $choice++;
            }

            return $elements;
        }

        /**
         * @param $guess
         *
         * @internal param $id
         *
         * @internal param $checkAnswer
         * @description
         *
         * @return bool
         */
        public function isCorrect($guess) {
            if ($this->getShuffled ()[$guess] == $this->getNumber ()) {
                return true;
            }

            return false;
        }

        /**
         * @name play
         * @description
         * @return $this
         */
        public function play() {
            $this->setNumber ($this->generateNumber ());
            $this->generateOptions ();
            $this->setShuffled ($this->shuffle ());

            return $this;
        }
    }

