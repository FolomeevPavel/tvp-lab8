<?php
namespace Facebook;

require __DIR__ .'\..\..\autoload.php';//������ �� ��������

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

FacebookSession::setDefaultApplication('652953054827427','b49af51fa67281d56221cbf693a079db');


class User {

private $me;
private $photo;
private $session;

public function __construct($token)
  {
   $this->session = new FacebookSession($token);
	try {
			$this->me =( new FacebookRequest($this->session, 'GET', '/me?locale=ru_RU'))->execute()->getGraphObject();
		} catch (FacebookRequestException $e) {
			echo $e;
		} catch (Exception $e) {
			echo $e;
		}
   }
   
   public function Name(){//
		return $this->me->getProperty('name');
   }
    public function event(){
		$this->event = (new FacebookRequest($this->session, 'GET', '/me/events'))->execute()->getGraphObject();
		$temp = $this->event->getProperty('data')->backingData;
		$array;
		$i=0;
		while($i<count($temp)){
			$array[$i]['name'] = $temp[$i]->name;
			$array[$i]['rsvp_status'] = $temp[$i]->rsvp_status;
			$array[$i]['id'] = $temp[$i]->id;
			$i++;
		}
		return $array;
   }
   public function Photo(){//
		$this->photo = (new FacebookRequest($this->session, 'GET', '/me/picture?type=large&redirect=false'))->execute()->getGraphObject();
		return $this->photo->getProperty('url'); 
   }
   
   public function Educations() {//
		$temp = $this->me->getProperty('education')->backingData;
		$array;
		$i=0;
		while($i<count($temp)){
			$array[$i]['name'] = $temp[$i]->school->name;
			$array[$i]['type'] = $temp[$i]->type;
			$array[$i]['year'] = $temp[$i]->year->name;
			$i++;
		}
		return $array;
   }
   
   public function Birthday(){
		return $this->me->getProperty('birthday');
   }
   
   public function Email(){
		return $this->me->getProperty('email');
   }
   public function Gender(){
		return $this->me->getProperty('gender');
   }
   
   public function HomeSweetHome(){
		return $this->me->getProperty('hometown')->backingData['name'];
   }
   
   public function Location(){
		return $this->me->getProperty('location')->backingData['name'];
   }
}
?>