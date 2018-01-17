<?php
/**
 * File: session.class.php
 * Project: Session
 * File Created: Monday, 18th December 2017 1:04:58 pm
 * @author ramon1611
 * -----
 * Last Modified: Wednesday, 17th January 2018 11:57:18 am
 * Modified By: ramon1611
 */

 namespace ramon1611\Libs;

 /**
  * Class ramon1611\Libs\Session
  * 
  * @api
  * @package Session
  */
class Session {
    private $_session = NULL;
    private $_sessions = NULL;
    
    /**
     * __construct
     * 
     * 
     * @param array $sessions
     * @param int $sessionID
     * @return void
     */
    public function __construct( array $sessions, int $sessionID ) {
        if ( isset( $sessions, $sessionID ) ) {
            $this->_sessions = $sessions;

            if ( isset( $this->_sessions[$sessionID] ) ) {
                $this->_session = array(
                    'ID'        => $sessionID,
                    'userID'    => $this->_sessions[$sessionID]['userID'],
                    'expire'    => $this->_sessions[$sessionID]['expire']
                );
            } else
                trigger_error( 'Session with SessionID "'.$sessionID.'" does not exist!', E_USER_ERROR );
        } else
            trigger_error( 'Some parts of the required Session-Data are empty!', E_USER_ERROR );
    }

    /**
     * Session::check
     * 
     * @param void
     * @return bool
     */
    public function check( ) {
        if ( $this->_session != NULL ) {
            if ( microtime(true) < $this->_session['expire'] || $this->_session['expire'] == -2 )
                return true;
            else
                return false;
        } else
            return false;
    }

    /**
     * Session::get
     * 
     * @param void
     * @return mixed
     */
    public function get( ) {
        if ( $this->_session != NULL )
            return $this->_session;
        else
            return false;
    }

    /**
     * Session::renew
     * 
     * @param float $newLifetime
     * @return mixed
     */
    public function renew( float $newLifetime ) {
        if ( $this->_session != NULL && isset( $newLifetime ) && $newLifetime != NULL ) {
            $this->_session['expire'] = microtime(true) + $newLifetime;
            return $this->_session;
        } else
            return false;
    }

    /**
     * Session::llap
     * 
     * @param void
     * @return mixed
     */
    public function llap( ) {
        if ( $this->_session != NULL ) {
            $this->_session['expire'] = -2;
            return $this->_session;
        } else
            return false;
    }
    
    /**
     * Session::kill
     * 
     * @param void
     * @return mixed
     */
    public function kill( ) {
        if ( $this->_session != NULL ) {
            $this->_session['expire'] = -1;
            return $this->_session;
        } else
            return false;
    }
}
?>
