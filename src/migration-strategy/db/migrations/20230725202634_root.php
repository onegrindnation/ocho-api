<?php

use Phinx\Db\Adapter\MysqlAdapter;

class Root extends Phinx\Migration\AbstractMigration
{
    public function change()
    {
        $this->table('review_reviews', [
                'id' => false,
                'primary_key' => ['id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('youtube_url', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 100,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'id',
            ])
            ->addColumn('definition', 'text', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::TEXT_MEDIUM,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'youtube_url',
            ])
            ->addIndex(['definition'], [
                'name' => 'ocho_review_reviews2_definition_index',
                'unique' => false,
                'type' => 'fulltext',
            ])
            ->create();
        $this->table('tournament_brackets', [
                'id' => false,
                'primary_key' => ['bracket_id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('bracket_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('tournament_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'bracket_id',
            ])
            ->addColumn('style_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'tournament_id',
            ])
            ->addIndex(['bracket_id'], [
                'name' => 'tournament_brackets_bracket_id_uindex',
                'unique' => true,
            ])
            ->create();
        $this->table('tournament_contestants', [
                'id' => false,
                'primary_key' => ['contestant_id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('contestant_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
            ])
            ->addColumn('tournament_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'contestant_id',
            ])
            ->addColumn('people_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'tournament_id',
            ])
            ->addColumn('contestant', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 40,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'people_id',
            ])
            ->addIndex(['tournament_id', 'people_id'], [
                'name' => 'tournament_id_2',
                'unique' => true,
            ])
            ->addIndex(['tournament_id', 'contestant'], [
                'name' => 'tournament_id',
                'unique' => true,
            ])
            ->create();
        $this->table('tournament_match', [
                'id' => false,
                'primary_key' => ['match_id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('match_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('tournament_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'match_id',
            ])
            ->addColumn('bracket_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'tournament_id',
            ])
            ->addColumn('match_recorded_at', 'datetime', [
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'after' => 'bracket_id',
            ])
            ->addColumn('heat', 'enum', [
                'null' => true,
                'default' => null,
                'limit' => 7,
                'values' => ['pit', 'bracket'],
                'after' => 'match_recorded_at',
            ])
            ->addColumn('ring', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'heat',
            ])
            ->addColumn('reeve', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 40,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'ring',
            ])
            ->addColumn('reeve_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'reeve',
            ])
            ->addColumn('contestant_1_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'reeve_id',
            ])
            ->addColumn('contestant_2_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'contestant_1_id',
            ])
            ->addColumn('outcome', 'enum', [
                'null' => true,
                'default' => null,
                'limit' => 12,
                'values' => ['contestant-1', 'contestant-2', 'draw'],
                'after' => 'contestant_2_id',
            ])
            ->addIndex(['match_id'], [
                'name' => 'tournament_match_match_id_uindex',
                'unique' => true,
            ])
            ->create();
        $this->table('tournament_people', [
                'id' => false,
                'primary_key' => ['person_id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('person_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('game', 'enum', [
                'null' => true,
                'default' => null,
                'limit' => 9,
                'values' => ['amtgard', 'belegarth', 'dagorhir', 'darkon'],
                'after' => 'person_id',
            ])
            ->addColumn('ork_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'game',
            ])
            ->addColumn('kingdom', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 4,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'ork_id',
            ])
            ->addColumn('park', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 4,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'kingdom',
            ])
            ->addColumn('person', 'string', [
                'null' => false,
                'limit' => 40,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'park',
            ])
            ->addIndex(['person', 'kingdom', 'park', 'game'], [
                'name' => 'contestant',
                'unique' => true,
            ])
            ->create();
        $this->table('tournament_reeve', [
                'id' => false,
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('reeve_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('person_id', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => MysqlAdapter::INT_REGULAR,
                'after' => 'reeve_id',
            ])
            ->addIndex(['reeve_id'], [
                'name' => 'tournament_reeve_reeve_id_index',
                'unique' => false,
            ])
            ->create();
        $this->table('tournament_style', [
                'id' => false,
                'primary_key' => ['style_id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('style_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
                'identity' => 'enable',
            ])
            ->addColumn('style', 'string', [
                'null' => true,
                'default' => null,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'style_id',
            ])
            ->addIndex(['style_id'], [
                'name' => 'tournament_style_style_id_uindex',
                'unique' => true,
            ])
            ->create();
        $this->table('tournament_tournament', [
                'id' => false,
                'primary_key' => ['tournament_id'],
                'engine' => 'InnoDB',
                'encoding' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'comment' => '',
                'row_format' => 'DYNAMIC',
            ])
            ->addColumn('tournament_id', 'integer', [
                'null' => false,
                'limit' => MysqlAdapter::INT_REGULAR,
            ])
            ->addColumn('tournament_date', 'datetime', [
                'null' => false,
                'after' => 'tournament_id',
            ])
            ->addColumn('game', 'enum', [
                'null' => false,
                'limit' => 9,
                'values' => ['amtgard', 'belegarth', 'dagorhir', 'darkon', 'other'],
                'after' => 'tournament_date',
            ])
            ->addColumn('kingdom', 'string', [
                'null' => false,
                'limit' => 4,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'game',
            ])
            ->addColumn('park', 'string', [
                'null' => false,
                'limit' => 4,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'kingdom',
            ])
            ->addColumn('event', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'park',
            ])
            ->addColumn('tournament', 'string', [
                'null' => false,
                'limit' => 20,
                'collation' => 'utf8mb4_general_ci',
                'encoding' => 'utf8mb4',
                'after' => 'event',
            ])
            ->addColumn('pit_style', 'enum', [
                'null' => true,
                'default' => null,
                'limit' => 9,
                'values' => ['none', 'by-streak', 'by-win'],
                'after' => 'tournament',
            ])
            ->addColumn('bracket_style', 'enum', [
                'null' => true,
                'default' => null,
                'limit' => 11,
                'values' => ['single-elim', 'double-elim'],
                'after' => 'pit_style',
            ])
            ->addColumn('bracket_best_of', 'enum', [
                'null' => true,
                'default' => null,
                'limit' => 9,
                'values' => ['first', 'best-of-3', 'best-of-5'],
                'after' => 'bracket_style',
            ])
            ->addIndex(['game', 'kingdom', 'park', 'event', 'tournament'], [
                'name' => 'game',
                'unique' => true,
            ])
            ->create();
    }
}
