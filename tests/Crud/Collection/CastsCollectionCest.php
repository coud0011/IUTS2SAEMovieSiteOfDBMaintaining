<?php

namespace Tests\Crud\Collection;

use Entity\Cast;
use Entity\Collections\CastsCollection;
use Tests\CrudTester;

class CastsCollectionCest
{
    public function findByMovieId(CrudTester $I): void
    {
        $expectedCasts = [
            ['id' => 19510, 'movieId' => 503314, 'peopleId' => 90496, 'role' => 'Son Goku / Son Goten / Bardock (voice)', 'orderIndex' => 0],
            ['id' => 19511, 'movieId' => 503314, 'peopleId' => 124478, 'role' => 'Bulma (voice)', 'orderIndex' => 1],
            ['id' => 19512, 'movieId' => 503314, 'peopleId' => 122501, 'role' => 'Vegeta (voice)', 'orderIndex' => 2],
            ['id' => 19513, 'movieId' => 503314, 'peopleId' => 85286, 'role' => 'Piccolo (voice)', 'orderIndex' => 3],
            ['id' => 19514, 'movieId' => 503314, 'peopleId' => 1686, 'role' => 'Trunks (voice)', 'orderIndex' => 4],
            ['id' => 19515, 'movieId' => 503314, 'peopleId' => 115305, 'role' => 'Frieza (voice)', 'orderIndex' => 5],
            ['id' => 19516, 'movieId' => 503314, 'peopleId' => 20664, 'role' => 'Beerus (voice)', 'orderIndex' => 6],
            ['id' => 19517, 'movieId' => 503314, 'peopleId' => 78402, 'role' => 'Whis (voice)', 'orderIndex' => 7],
            ['id' => 19518, 'movieId' => 503314, 'peopleId' => 126690, 'role' => 'Shenron (voice)', 'orderIndex' => 8],
            ['id' => 19519, 'movieId' => 503314, 'peopleId' => 554432, 'role' => 'Paragus (voice)', 'orderIndex' => 9],
            ['id' => 19520, 'movieId' => 503314, 'peopleId' => 122192, 'role' => 'Gine (voice)', 'orderIndex' => 10],
            ['id' => 19521, 'movieId' => 503314, 'peopleId' => 122481, 'role' => 'King Vegeta (voice)', 'orderIndex' => 11],
            ['id' => 19522, 'movieId' => 503314, 'peopleId' => 105816, 'role' => 'Raditz (voice)', 'orderIndex' => 12],
            ['id' => 19523, 'movieId' => 503314, 'peopleId' => 126704, 'role' => 'Nappa (voice)', 'orderIndex' => 13],
            ['id' => 19524, 'movieId' => 503314, 'peopleId' => 24651, 'role' => 'Chirai (voice)', 'orderIndex' => 14],
            ['id' => 19525, 'movieId' => 503314, 'peopleId' => 144655, 'role' => 'Remo (voice)', 'orderIndex' => 15],
            ['id' => 19526, 'movieId' => 503314, 'peopleId' => 112135, 'role' => 'Kikono (voice)', 'orderIndex' => 16],
            ['id' => 19527, 'movieId' => 503314, 'peopleId' => 1241603, 'role' => 'Berryblue (voice)', 'orderIndex' => 17],
            ['id' => 19528, 'movieId' => 503314, 'peopleId' => 1769320, 'role' => 'Broly (Kid) (voice)', 'orderIndex' => 18],
            ['id' => 19529, 'movieId' => 503314, 'peopleId' => 1037692, 'role' => 'Beets (voice)', 'orderIndex' => 19],
            ['id' => 19530, 'movieId' => 503314, 'peopleId' => 122654, 'role' => 'Moroko (voice)', 'orderIndex' => 20],
            ['id' => 19531, 'movieId' => 503314, 'peopleId' => 1254247, 'role' => 'Shito (voice)', 'orderIndex' => 21],
            ['id' => 19532, 'movieId' => 503314, 'peopleId' => 2220797, 'role' => 'Leek (voice)', 'orderIndex' => 22],
            ['id' => 19533, 'movieId' => 503314, 'peopleId' => 216330, 'role' => 'Daigen (voice)', 'orderIndex' => 23],
            ['id' => 19534, 'movieId' => 503314, 'peopleId' => 115790, 'role' => 'Broly (voice)', 'orderIndex' => 24],
            ['id' => 19535, 'movieId' => 503314, 'peopleId' => 1241513, 'role' => 'Butler (voice) (uncredited)', 'orderIndex' => 25],
            ['id' => 19536, 'movieId' => 503314, 'peopleId' => 1243481, 'role' => 'Saiyan (voice) (uncredited)', 'orderIndex' => 26],
            ['id' => 19537, 'movieId' => 503314, 'peopleId' => 122661, 'role' => 'Freeza Force Soldier (voice) (uncredited)', 'orderIndex' => 27],
        ];
        $casts = CastsCollection::findByMovieId(503314);
        $I->assertCount(count($expectedCasts), $casts);
        $I->assertContainsOnlyInstancesOf(Cast::class, $casts);
        foreach ($casts as $index => $cast) {
            $expectedCast = $expectedCasts[$index];
            $I->assertEquals($expectedCast['id'], $cast->getId());
            $I->assertEquals($expectedCast['movieId'], $cast->getMovieId());
            $I->assertEquals($expectedCast['peopleId'], $cast->getPeopleId());
            $I->assertEquals($expectedCast['role'], $cast->getRole());
            $I->assertEquals($expectedCast['orderIndex'], $cast->getOrderIndex());
        }
    }

    public function findByActorId(CrudTester $I): void
    {
        $expectedCasts = [
            ['id' => 19510, 'movieId' => 503314, 'peopleId' => 90496, 'role' => 'Son Goku / Son Goten / Bardock (voice)', 'orderIndex' => 0],
        ];
        $casts = CastsCollection::findByActorId(90496);
        $I->assertCount(count($expectedCasts), $casts);
        $I->assertContainsOnlyInstancesOf(Cast::class, $casts);
        foreach ($casts as $index => $cast) {
            $expectedCast = $expectedCasts[$index];
            $I->assertEquals($expectedCast['id'], $cast->getId());
            $I->assertEquals($expectedCast['movieId'], $cast->getMovieId());
            $I->assertEquals($expectedCast['peopleId'], $cast->getPeopleId());
            $I->assertEquals($expectedCast['role'], $cast->getRole());
            $I->assertEquals($expectedCast['orderIndex'], $cast->getOrderIndex());
        }
    }
}
