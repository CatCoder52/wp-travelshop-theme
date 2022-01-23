<?php
/**
 * This is only pseudo code! do not use in production!
 * <code>
 * $args['name']
 * </code>
 * @var array $args
 */

$terms = ['oft', 'einige Male', 'regelmäßig', 'von Stammkunden oft'];
$str = rand(10, 30) < 15 ? $terms[array_rand($terms, 1)] : rand(100, 362).'&nbsp;Mal';
$user_count = rand(0, rand(5, 24));

$user_str = $user_count.' weitere Nutzer online.';
if($user_count == 1){
    $user_str = 'Ein weiterer Nutzer online.';
}
?>
<div class="trust-box">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mood-smile" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#27ae60" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <circle cx="12" cy="12" r="9" />
        <line x1="9" y1="10" x2="9.01" y2="10" />
        <line x1="15" y1="10" x2="15.01" y2="10" />
        <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
    </svg>
    <br />
    <strong>Diese Reise interessiert viele Leute</strong>
    <p>Die Reise <?php echo !empty($args['name']) ? '"'.$args['name'].'"' : ''; ?> wurde in den letzten Monaten <?php echo $str; ?> gebucht.</p>
    <?php if($user_count > 0){ ?>
    <span class="small">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="14" height="14" viewBox="0 0 24 24" stroke-width="1.5" stroke="#27ae60" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <circle cx="12" cy="12" r="2" />
        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
        </svg>
        <?php echo $user_str; ?>
        </span>
    <?php } ?>
</div>