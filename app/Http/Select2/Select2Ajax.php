<?php

namespace App\Http\Select2;
use App\Http\Select2\Select2Config;
use Illuminate\Support\Facades\DB;

/**
 * Controller to handle select2 ajax request
 *
 * @author achmadmunandar
 */
class Select2Ajax
{
    const limit = 10;

    public static function getAjaxDataByKey($key, $page, $search, $params = [])
    {
        $page--;
        $config = Select2Config::getConfig($key);
        $sql    = DB::table($config['table'])->distinct();
        $sql    = self::prepareJoins($sql, $config);
        if (array_key_exists('where', $config)) {
            foreach ($config['where'] as $where) {
                if (sizeof($where) == 1) {
                    $sql->whereRaw($where[0]);
                } else if (sizeof($where) == 2) {
                    $sql->where($where[0], $where[1]);
                } else if (sizeof($where) == 3) {
                    $sql->where($where[0], $where[1], $where[2]);
                }
            }
        }
        if (array_key_exists('params', $config) && sizeof($params) > 0) {
            foreach ($params AS $i => $val) {
                $sql->where($config['params'][$i], $val);
            }
        }
        if (strlen($search) > 0) {
            self::prepareSearch($sql, $config, $search);
        }

        if (array_key_exists('groupBy', $config)) {
            $sql->groupBy($config['groupBy']);
        }

        $sql = self::prepareSelect($sql, $config);
        $sql->take(self::limit)->skip((self::limit * $page));
        return [
            'items' => $sql->get(),
            'total' => self::getTotalRow($config, $sql),
        ];
    }

    public static function getAjaxDataByConfig($config, $page, $search)
    {
        $page--;
        $sql = DB::table($config['table']);
        $sql = self::prepareJoins($sql, $config);
        if (array_key_exists('where', $config)) {
            foreach ($config['where'] as $where) {
                if (sizeof($where) == 2) {
                    $sql->where($where[0], $where[1]);
                } else if (sizeof($where) == 3) {
                    $sql->where($where[0], $where[1], $where[2]);
                }
            }
        }
        if (strlen($search) > 0) {
            self::prepareSearch($sql, $config, $search);
        }

        if (array_key_exists('groupBy', $config)) {
            $sql->groupBy($config['groupBy']);
        }

        $sql = self::prepareSelect($sql, $config);
        $sql->take(self::limit)->skip((self::limit * $page));
        return [
            'total' => self::getTotalRow($config, $sql),
            'items' => $sql->get(),
        ];
    }

    private static function getTotalRow($config, $sql)
    {
        if (array_key_exists('distinct', $config) && $config['distinct']) {
            if (is_array($config['id'])) {
                return DB::table($config['table'])->select(DB::raw("COUNT(CONCAT_WS('-',".implode(",",
                                $config['id']).")) AS total"))->first()->total;
            } else {
                return $sql->select(DB::raw("COUNT(".$config['id'].") AS total"))->first()->total;
            }
        } else {
            return $sql->count();
        }
    }

    public static function getTextByKey($key, $id)
    {
        $config = Select2Config::getConfig($key);
        $sql    = DB::table($config['table']);
        $sql    = self::prepareSelect($sql, $config);
        $sql    = self::prepareJoins($sql, $config);
        $sql->where($config['id'], $id);
        $result = $sql->first();
        if ($result) {
            return $result->text;
        }
        return null;
    }

    private static function prepareSelect($sql, $config)
    {
        if (array_key_exists('distinct', $config)) {
            if ($config['distinct']) {
                $sql->distinct();
            }
        }
        if (is_array($config['id'])) {
            $sql->select(DB::raw("CONCAT_WS('#',".implode(",",
                        $config['id']).") AS id"));
        } else {
            $sql->select($config['id'].' AS id');
        }
        if (is_array($config['text'])) {
            $textArray = $config['text'];
            if (array_key_exists('prefix', $config) || array_key_exists('suffix',
                    $config)) {
                $textArray = [];
                foreach ($config['text'] AS $key => $col) {
                    $colSQL = null;
                    if (array_key_exists('prefix', $config)) {
                        if (array_key_exists($key, $config["prefix"])) {
                            $colSQL = "CONCAT('".$config["prefix"][$key]." '";
                        }
                    }
                    if ($colSQL == null) {
                        $colSQL = "CONCAT(".$col;
                    } else {
                        $colSQL .= ",".$col;
                    }
                    if (array_key_exists('suffix', $config)) {
                        if (array_key_exists($key, $config["suffix"])) {
                            $colSQL .= ",' ".$config["suffix"][$key]."'";
                        }
                    }
                    $colSQL      .= ")";
                    $textArray[] = $colSQL;
                }
            }
            $sql->addSelect(DB::raw("CONCAT_WS(' -- ',".implode(",",
                        $textArray).") AS text"));
        } else {
            $sql->addSelect($config['text'].' AS text');
        }
        return $sql;
    }

    private static function prepareJoins($sql, $config)
    {
        if (array_key_exists('join', $config)) {
            foreach ($config['join'] AS $join) {
                $sql->join($join[0], $join[1], $join[2], $join[3]);
            }
        }
        if (array_key_exists('leftJoin', $config)) {
            foreach ($config['leftJoin'] AS $join) {
                $sql->leftJoin($join[0], $join[1], $join[2], $join[3]);
            }
        }
        return $sql;
    }

    private static function prepareSearch($sql, $config, $search)
    {
        if (is_array($config['text'])) {
            $criterias = [];
            foreach ($config['text'] AS $col) {
                $criterias[] = "UPPER(".$col.") LIKE '%".$search."%'";
            }
            $sql->whereRaw("(".implode(" OR ", $criterias).")");
        } else {
            $sql->whereRaw("UPPER(".$config['text'].") LIKE '%".$search."%'");
//            $sql->where($config['text'], 'like',
//                '%'.$search.'%');
        }
        return $sql;
    }
}