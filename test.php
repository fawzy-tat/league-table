<?php

class LeagueTable
{
    public function __construct(array $players)
    {
        $this->standings = [];
        foreach($players as $index => $p) {
            $this->standings[$p] = [
                'index'        => $index,
                'games_played' => 0,
                'score'        => 0
            ];
        }
    }

    public function recordResult(string $player, int $score) : void
    {
        $this->standings[$player]['games_played']++;
        $this->standings[$player]['score'] += $score;
    }

    // public function playerRank(int $rank) : string
    // {
    //     $ranks = $this->standings;
    //     uasort($ranks, function ($a, $b) {
    //         // sort by score
    //         if ($a['score'] != $b['score']) 
    //             return ($a['score'] > $b['score']) ? -1 : 1;
    //         // equal! sort by games played
    //         if ($a['games_played'] != $b['games_played'])
    //             return ($a['games_played'] < $b['games_played']) ? -1 : 1;
    //         // equal! sort by index
    //         return ($a['index'] < $b['index']) ? -1 : 1;
    //     });
    
    //     return array_keys($ranks)[$rank-1];
    // }

    public function playerRank(int $rank) : string
    {
        
        $data = $this->standings;
        $sorted_data=[];

        array_multisort(
                array_column($data, 'score'),  SORT_DESC,
                array_column($data, 'games_played'), SORT_ASC,
                array_column($data, 'index'), SORT_ASC,
                $data);
        
         $current_rank = 1;
         foreach($data as $player_name => $value)
         {
            $sorted_data['rank'] = $current_rank;
            $sorted_data[$current_rank]['name'] = $player_name;
            $current_rank++;
         }
    
    return $sorted_data[strval($rank)]["name"];
    }

}

$table = new LeagueTable(array('Mike', 'Chris', 'Arnold'));
$table->recordResult('Mike', 2);
$table->recordResult('Mike', 3);
$table->recordResult('Arnold', 5);
$table->recordResult('Chris', 5);
echo $table->playerRank(1);