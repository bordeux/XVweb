{capture name="ADVBanner"}
<div class="admob xv-adv"></div>
{/capture}
{capture name="ADVBottomText"}
<div class="admob xv-adv"></div>
{/capture}
{capture name="ADVComments"}
<div class="admob xv-adv"></div>
{/capture}
{capture name="ADVInfo"}

{/capture}
{capture name="ADVFooter"}
<div class="admob xv-adv"></div>

<script type="text/javascript"><!--
  // XHTML should not attempt to parse these strings, declare them CDATA.
  /* <![CDATA[ */
  var admob_vars = {
	 pubid: 'a14e527580ce723', // publisher id
	 bgcolor: '000000', // background color (hex)
	 text: 'FFFFFF', // font-color (hex)
	 test: false, // test mode, set to false to receive live ads
	 manual_mode: true
	};
	$(document).bind("pagecreate", function() {
		$(".admob").each(function(){
			$(this).html("");
			 _admob.fetchAd(this);
		});
    });
	
  /* ]]> */
//-->
</script>
<script type="text/javascript" src="http://mmv.admob.com/static/iphone/iadmob.js"></script>
{/capture}