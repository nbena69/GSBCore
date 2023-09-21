<?php
/**
 * Authentifie le visiteur sur son login et Mdp
 * Si c'est OK, son id est enregistrer dans la session
 * Cela lui donne accès au menu général (voir page master)
 * @param type $login : Login du Visiteur
 * @param type $pwd : MDP du Visiteur
 * @return boolean : True or false
 */

public function login(type $login, $pwd) {
    $connected = false;
    try {
        $visiteur = DB::table('visiteur')
            ->select()
            ->where('login_visiteur', '=', $login)
            ->first();
        if ($visiteur) {
            // if ($visiteur->pwd_visiteur == md5($pwd) {
            if ($visiteur->pwd_visiteur == $pwd) {
                Session::put('id', $visiteur->id_visiteur);
                Session::put('type', $visiteur->type_visiteur);
                $connected = true;
            }
        }
    } catch (QueryException $e) {
        throw new MonException($e->getMessage(), 5);
    }
    return $connected;
}
?>


