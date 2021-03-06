<?php include("header.php"); ?>

<!-- Google intro -->

<?php
  require_once("inc/config.php");
  require_once("inc/security.php");
  require_once("inc/balance.php");
  require_once("inc/RewardManager.php");
  require_once("inc/GoogleConnector.php");
  require_once("inc/Debug.php");
  
  // Check, if Cookie check is enabled
  if($checkCookie)
  {
    if(cookieExists())
    {
      Debug::Log("Cookie exists, TXID: ".retrieveCookie());
      header("Location: /already-claimed");
    }
  }
  
  // Check, if IP check is enabled
  if($checkHost)
  {
    $sql = new RewardManager();
    if($sql->countRewardsByIp() != 0)
    {
      Debug::Log("IP already claimed a reward");
      header("Location: /already-claimed");
    }
  }
  
  $uid = generateUid();
  registerUid($uid);
  
  $connector = new GoogleConnector();
  $url = $connector->getAuthUrl($uid);
?>

  <span class="description">
    <p>Okay, you chose <strong>Google</strong> as authentication method. You can earn <strong><?php echo 
    getAmountLabelLong("github"); ?></strong> with this method, if you have an Google account.</p>
    
    <p>You will be forwarded to <strong>Google</strong>. There you need to grant access to an application called 
    <strong>Mastercoin faucet</strong>. You will be redirected to this page, after you finished the process. You 
    can revoke the application access later <a href="https://accounts.google.com/b/0/IssuedAuthSubTokens" target="_blank">
    <strong>here</strong></a>. This step is solely a protection against abuse, so we are able to give out <strong>
    free MCS</strong> to as many interested people as possible.</p>
    
    <p>Please <a href="<?php echo $url; ?>"><strong>click here</strong></a> to initiate the 
    <strong>authentication</strong>, if you like to proceed.</p>
  </span>
  
  <div class="thumbnail">
    <div class="row">
      <div class="col-sm-6"><img class="preview" src="img/authgoogle.png" alt="Google authentication" ></div>
      <div class="col-sm-6"><img class="preview" src="img/authgoogledone.png" alt="Successful authentication"></div>
    </div>
  </div>
  
  <p>Or <a href="/"><strong>go back</strong></a> instead.</p>
  
<!-- /Google intro -->

<?php include("footer.php"); ?>