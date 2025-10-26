<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManagerLiens;

class GestionLiensUtilisateurAdminController extends Controller {

    protected $identifiant_session = "utilisateur_liens";
    protected $liens = [], $parent_name = [];

    public function pushLiens(ManagerLiens $request) {

        if (!$request->ajax()) {
            abort(404);
        }

        $this->liens = $request->liens;
        $lien_parent = explode('-', $request->parent_name);
        foreach ($lien_parent as $value) {
            if ($value != "" && isset($this->liens[$value])) {
                $this->parent_name[] = $this->liens[$value];
            }
        }
        if (count($this->parent_name) == 0) {
            $this->parent_name[] = $request->name;
        }
        if ($this->in_breadcrumb($request)) {
            $session = $request->session()->get($this->identifiant_session);
            dd($session);
            $clone_session = [];
            if ($this->in_breadcrumb_parent($request)) {
                $clone_session['parent'] = $session['parent'];
                $clone_session['parent']['class'] = 'active';
                $clone_session['childres'] = [];
            } else {
                $clone_session['parent'] = $session['parent'];
                for ($i = 0; $i < count($session['childres']); $i++) {
                    $clone_session['childres'][$i] = $session['childres'][$i];
                    $clone_session['childres'][$i]['class'] = '';
                    if (in_array($session['childres'][$i]['href'], [$request->href])) {
                        $clone_session['childres'][$i]['class'] = 'active';
                        $i = count($session['childres']);
                    }
                }
            }
            $request->session()->put($this->identifiant_session, $clone_session);
        } else if ($this->is_parent($request) && !$request->is_parent) {
            $session = $request->session()->get($this->identifiant_session);
            $session['parent']['class'] = '';
            $session['childres'] = $this->push_childre(
                    [
                'class' => '',
                'name' => $request->name,
                'href' => $request->href,
                'range' => $request->range,
                    ], $session, $request);
            $request->session()->put($this->identifiant_session, $session);
        } else if ($request->is_parent) {
            $request->session()->put($this->identifiant_session, [
                'parent' => [
                    'class' => 'active',
                    'parent' => $this->parent_name[0],
                    'name' => $request->name,
                    'href' => $request->href
                ],
                'childres' => [
                ]
            ]);
        } else {
            $request->session()->put($this->identifiant_session, [
                'parent' => [
                    'class' => 'active',
                    'parent' => $request->name,
                    'name' => $request->name,
                    'href' => $request->href
                ],
                'childres' => [
                ]
            ]);
        }

        //$request->session()->forget($this->identifiant_session);
        return [
            'href' => $request->session()->get($this->identifiant_session)
        ];
    }

    private function push_childre($session_push, $session, $request) {
        $session['childres'] = isset($session['childres']) ? $session['childres'] : [];
        $clone_childre = [];
        $not_push = true;
        for ($index = 0; $index < count($session['childres']) && $session_push['range'] > $index; $index++) {
            $session['childres'][$index]['class'] = '';
            $clone_childre[$index] = $session['childres'][$index];
            if (isset($session_push['name']) && $session_push['name'] == $clone_childre[$index]['name']) {
                $clone_childre[$index]['class'] = 'active';
                $index = count($session['childres']);
                $not_push = false;
            }
        }
        if (isset($session_push['name']) && $not_push) {
            $clone_childre[count($clone_childre)] = [
                'name' => $session_push['name'],
                'href' => $session_push['href'],
                'class' => 'active'
            ];
        }
        return $clone_childre;
    }

    private function is_parent($request) {
        return $request->session()->exists($this->identifiant_session) &&
                isset($request->session()->get($this->identifiant_session)['parent']) &&
                in_array($request->session()->get($this->identifiant_session)['parent']['parent'], $this->parent_name);
    }

    private function in_breadcrumb($request) {
        return $request->session()->exists($this->identifiant_session) &&
                (
                $this->in_breadcrumb_parent($request) || $this->in_breadcrumb_childre($request)
                );
    }

    private function in_breadcrumb_parent($request) {
        return isset($request->session()->get($this->identifiant_session)['parent']) &&
                in_array($request->session()->get($this->identifiant_session)['parent']['href'], [$request->href]);
    }

    private function in_breadcrumb_childre($request) {
        return isset($request->session()->get($this->identifiant_session)['childres']) &&
                in_array(
                        $request->href, array_map(function($arr) {
                            return $arr['href'];
                        }, $request->session()->get($this->identifiant_session)['childres'])
        );
    }

}
