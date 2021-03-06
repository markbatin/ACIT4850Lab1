<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            //Sets up game and allows it to display and use all the functons.
            $position = $_GET['board'];
            $game = new Game($position);
            $game->pick_move();
            $game->display();

            if($game->Winner('x')){
                echo '<p style="font-size:300%">You win!<p>'; //User wins               
            }
            else if ($game->Winner('o')){
                echo '<p style="font-size:300%">I win!</p>';
            }
            else {
                echo '<p style="font-size:300%">No winner yet!</p>';
            }
            
            ?>
        
        
       </body>
</html>
<?php        
            class Game {
                var $position;
                function Game($squares){
                    $this->position = str_split($squares);
                }
                function display(){
                    echo '<p style="font-size:300%">Welcome to Rival, the evil tic-tac-toe game.</p>';
                    echo '<table cols="3" style="font-size:500%; font-weight:bold; width:50%;">'; //Creates a new table to display x's and o's
                    echo '<tr>'; //Create a new table row.
                    for($pos=0; $pos<9; $pos++){
                        echo $this->show_cell($pos);
                        if($pos %3 == 2){ echo '</tr><tr>';} // Starts new row for next square.
                    }
                    echo '</tr>';// Closes table row.
                    echo '</table>'; // Closes table.
                }

                function show_cell($which){
                    $token = $this->position[$which];
                    if($token <> '-'){ return '<td>'.$token.'</td>';}   //If there's a free slot this allows you to execute code
                    $this-> newposition = $this->position;              // copy the original
                    $this-> newposition[$which] = 'x';                  // this would be their move
                    $move = implode($this->newposition);                // make a string from the board array
                    
                    $link = 'http://localhost:8080/ACIT4850Lab1/index.php/?board='.$move; //Changes URL to accomadate changes.
                    return '<td><a href="'.$link.'">-</a></td>'; //New link
                }
                
                //Bot picks its own move. Very simple AI.
                function pick_move() {
                    for($i=0; $i<8; $i++){
                        if($this->position[$i] == '-'){ //Replaces any - with an o.
                           $this->position[$i] = 'o';
                           break;
                        }
                    }
                }                
                
                function Winner($token){
                    $winner = false;
                    //Winning rows horizontally.
                    for($row=0; $row<3; $row++){
                    if( ($this->position[3*$row] == $token) && 
                        ($this->position[3*$row+1] == $token) && 
                        ($this->position[3*$row+2] == $token))
                        { 
                            $winner = true; 
                        }
                    }
                    //Winning rows vertically.
                    for($col=0; $col<3; $col++){
                    if( ($this->position[$col] == $token) && 
                        ($this->position[$col+3] == $token) && 
                        ($this->position[$col+6] == $token))
                        { 
                            $winner = true; 
                        }
                    }
                    //Left to right diagonal starting from the top.
                    if( ($this->position[0] == $token) && 
                        ($this->position[4] == $token) && 
                        ($this->position[8] == $token))
                        { 
                            $winner = true; 
                        }
                    //Right to left diagonal starting from the top.
                    else if(($this->position[2] == $token) && 
                        ($this->position[4] == $token) && 
                        ($this->position[6] == $token))
                        { 
                            $winner = true; 
                        }
                return $winner;   
            }
        }
    ?>