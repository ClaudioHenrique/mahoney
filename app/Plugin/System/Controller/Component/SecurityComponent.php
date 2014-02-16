<?php
/**
 * The Security component has common tasks for security
 */
class SecurityComponent extends Component {

    function genRandom($len, $salt = null) {
        if (empty($salt)) {
            $salt = $this->salt('a', 'z') . $this->salt('A', 'Z') . $this->salt('0', '9');
        }

        $str = "";

        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($salt) - 1);
            $str .= $salt[$index];
        }

        return $str;
    }

    function salt($from, $end) {
        $salt = '';

        for ($no = ord($from); $no <= ord($end); $no++) {
            $salt .= chr($no);
        }

        return $salt;
    }

}
