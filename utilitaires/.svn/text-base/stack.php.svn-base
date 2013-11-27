<?php
/*
    utilitaires/stack.php
    This file is part of POOF.

    POOF is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    
    POOF is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with POOF; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
* A stack data structure. A stack is a LIFO (Last In First Out) data structure.
* @author Brian Takita <brian.takita@runbox.com>
* @version 1.1
*/
class Stack {
    /**
    * @var array The Stack data.
    * @access private
    */
    var $_stack = array();
    
    /**
    * Push the argument onto the stack.
    * @param mixed $content The element to be pushed onto the stack.
    */
    function push($element) {
        array_push($this->_stack, $element);//array_push($this->_stack, &$element);
    }
    
    /**
    * Pop the Stack.
    * @returns mixed The reference to the popped element.
    */
    function &pop() {
        $element = &$this->top();
        array_pop($this->_stack);
        return $element;
    }
    
    /**
    * Returns a reference to the top of the stack.
    * @returns mixed A reference to the top of the stack.
    */
    function &top() {
        $count = count($this->_stack);
        // Prevent bad reference pointer
        if ($count == 0) {
            return null;
        }
        return $this->_stack[count($this->_stack)-1];
    }
    /**
    * Retourne une référence sur un élément quelconque de la pile
    * @param int rang de l'élément à retourner.
    * @returns mixed A reference to un élément quelconque of the stack.
    * @author jcb 2005
    */
    function &get_element($i) {
        $count = count($this->_stack);
        // Prevent bad reference pointer
        if ($count == 0 || $i < 0 || $i >$count-1) {
            return null;
        }
        return $this->_stack[$i];
    }
    
    /**
    * Get the lenght of the Stack.
    * @returns int The lenght of the Stack.
    */
    function get_length() {
        return count($this->_stack);
    }
    /**
    * Imprime le contenu de la pile.
    * JCB 2005
    */
    function write_reverse_stack(){
    	$n = count($this->_stack);
	if($n != 0){
		for($i=$n-1;$i>-1;$i--)
			echo $this->_stack[$i].'/';
	}
    }
    function write_stack(){
    	$n = count($this->_stack);
	if($n != 0){
		for($i=0;$i<$n;$i++)
			echo $this->_stack[$i].'/';
	}
    }
}
?>