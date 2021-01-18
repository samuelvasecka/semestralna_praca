<?php
declare(strict_types=1);

class Results
{
    static public function createResults($candidates) : array {
        $total_votes = 0;
        foreach ($candidates as $candidate) {
            $total_votes += $candidate->votes;
        }

        for ($i = 0; $i < count($candidates); $i++) {
            if ($total_votes != 0) {
                $candidates[$i]->percentage = round($candidates[$i]->votes / $total_votes * 100, 1);
            } else {
                $candidates[$i]->percentage = 0;
            }
        }
        return $candidates;
    }
}