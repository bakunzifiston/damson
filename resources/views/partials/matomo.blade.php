{{-- Matomo: configure before trackPageView; heartbeat + link tracking for engagement & outbound/downloads --}}
<script>
  var _paq = window._paq = window._paq || [];
  var u = "//analytics.redp.rw/";
  _paq.push(['setTrackerUrl', u + 'matomo.php']);
  _paq.push(['setSiteId', '8']);
  _paq.push(['enableHeartBeatTimer', 15]);
  _paq.push(['enableLinkTracking']);
  _paq.push(['trackPageView']);
  (function() {
    var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
    g.async = true;
    g.src = u + 'matomo.js';
    s.parentNode.insertBefore(g, s);
  })();
</script>
<noscript>
    {{-- Matomo Image Tracker (no JS) --}}
    <img referrerpolicy="no-referrer-when-downgrade" src="https://analytics.redp.rw/matomo.php?idsite=8&amp;rec=1" style="border:0" alt="" />
</noscript>
{{-- End Matomo --}}
