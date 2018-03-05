<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/5
 * Time: 17:11
 */

namespace Universe\Support;

/**
 * @method \Illuminate\Database\Eloquent\Model make(array $attributes=array())
 * @method \Illuminate\Database\Eloquent\Builder withGlobalScope($identifier,$scope) static
 * @method \Illuminate\Database\Eloquent\Builder withoutGlobalScope($scope) static
 * @method \Illuminate\Database\Eloquent\Builder withoutGlobalScopes(array $scopes=NULL) static
 * @method array removedScopes()
 * @method \Illuminate\Database\Eloquent\Builder whereKey($id) static
 * @method \Illuminate\Database\Eloquent\Builder whereKeyNot($id) static
 * @method \Illuminate\Database\Eloquent\Builder where($column,$operator=NULL,$value=NULL,$boolean='and') static
 * @method \Illuminate\Database\Eloquent\Builder forPage($page, $perPage) static
 * @method \Illuminate\Database\Eloquent\Builder orWhere($column,$operator=NULL,$value=NULL) static
 * @method \Illuminate\Database\Eloquent\Builder orderBy($column, $direction = 'asc') static
 * @method \Illuminate\Database\Eloquent\Builder leftJoin($table, $first, $operator = null, $second = null) static
 * @method \Illuminate\Database\Eloquent\Builder rightJoin($table, $first, $operator = null, $second = null) static
 * @method \Illuminate\Database\Eloquent\Collection hydrate(array $items)
 * @method \Illuminate\Database\Eloquent\Collection fromQuery($query,$bindings=array())
 * @method \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null find($id,$columns=array(0=>'*',)) static
 * @method \Illuminate\Database\Eloquent\Collection findMany($ids,$columns=array(0=>'*',))
 * @method \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection findOrFail($id,$columns=array(0=>'*',))
 * @method \Illuminate\Database\Eloquent\Model findOrNew($id,$columns=array(0=>'*',))
 * @method \Illuminate\Database\Eloquent\Model firstOrNew(array $attributes,array $values=array())
 * @method \Illuminate\Database\Eloquent\Model firstOrCreate(array $attributes,array $values=array())
 * @method \Illuminate\Database\Eloquent\Model updateOrCreate(array $attributes,array $values=array())
 * @method \Illuminate\Database\Eloquent\Model|static firstOrFail($columns=array(0=>'*',)) static
 * @method \Illuminate\Database\Eloquent\Model|static|mixed firstOr($columns=array(0=>'*',),\Closure $callback=NULL) static
 * @method mixed value($column)
 * @method \Illuminate\Database\Eloquent\Collection|static[] get($columns=array(0=>'*',)) static
 * @method \Illuminate\Database\Eloquent\Model[] getModels($columns=array(0=>'*',))
 * @method array eagerLoadRelations(array $models)
 * @method \Generator cursor()
 * @method bool chunkById($count,callable $callback,$column=NULL,$alias=NULL)
 * @method \Illuminate\Support\Collection pluck($column,$key=NULL)
 * @method \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage=NULL,$columns=array(0=>'*',),$pageName='page',$page=NULL) static
 * @method \Illuminate\Contracts\Pagination\Paginator simplePaginate($perPage=NULL,$columns=array(0=>'*',),$pageName='page',$page=NULL)
 * @method \Illuminate\Database\Eloquent\Model|$this create(array $attributes=array())
 * @method \Illuminate\Database\Eloquent\Model|$this forceCreate(array $attributes)
 * @method void onDelete(\Closure $callback)
 * @method mixed scopes(array $scopes)
 * @method \Illuminate\Database\Eloquent\Builder|static applyScopes() static
 * @method \Illuminate\Database\Eloquent\Builder without($relations) static
 * @method \Illuminate\Database\Eloquent\Model newModelInstance($attributes=array())
 * @method \Illuminate\Database\Query\Builder getQuery()
 * @method \Illuminate\Database\Eloquent\Builder setQuery($query) static
 * @method \Illuminate\Database\Query\Builder toBase()
 * @method array getEagerLoads()
 * @method \Illuminate\Database\Eloquent\Builder setEagerLoads(array $eagerLoad) static
 * @method \Illuminate\Database\Eloquent\Model getModel()
 * @method \Illuminate\Database\Eloquent\Builder setModel(\Illuminate\Database\Eloquent\Model $model) static
 * @method \Closure getMacro($name)
 * @method void __clone()
 * @method bool chunk($count,callable $callback)
 * @method bool each(callable $callback,$count=1000)
 * @method \Illuminate\Database\Eloquent\Model|object|static|null first($columns=array(0=>'*',)) static
 * @method mixed when($value,$callback,$default=NULL)
 * @method \Illuminate\Database\Query\Builder tap($callback)
 * @method mixed unless($value,$callback,$default=NULL)
 * @method \Illuminate\Database\Eloquent\Builder|static has($relation,$operator='>=',$count=1,$boolean='and',\Closure $callback=NULL) static
 * @method \Illuminate\Database\Eloquent\Builder|static orHas($relation,$operator='>=',$count=1) static
 * @method \Illuminate\Database\Eloquent\Builder|static doesntHave($relation,$boolean='and',\Closure $callback=NULL) static
 * @method \Illuminate\Database\Eloquent\Builder|static orDoesntHave($relation) static
 * @method \Illuminate\Database\Eloquent\Builder|static whereHas($relation,\Closure $callback=NULL,$operator='>=',$count=1) static
 * @method \Illuminate\Database\Eloquent\Builder|static orWhereHas($relation,\Closure $callback=NULL,$operator='>=',$count=1) static
 * @method \Illuminate\Database\Eloquent\Builder|static whereDoesntHave($relation,\Closure $callback=NULL) static
 * @method \Illuminate\Database\Eloquent\Builder|static orWhereDoesntHave($relation,\Closure $callback=NULL) static
 * @method \Illuminate\Database\Eloquent\Builder withCount($relations) static
 * @method \Illuminate\Database\Eloquent\Builder|static mergeConstraintsFrom(\Illuminate\Database\Eloquent\Builder $from) static
 */

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}