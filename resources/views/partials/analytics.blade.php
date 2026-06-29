@if(env('GA_MEASUREMENT_ID'))
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_MEASUREMENT_ID') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);} gtag('js', new Date());
  gtag('config', '{{ env('GA_MEASUREMENT_ID') }}');
</script>
@endif

@if(env('SENTRY_DSN'))
<!-- Sentry (error reporting) -->
<script src="https://browser.sentry-cdn.com/7.0.0/bundle.tracing.min.js" crossorigin="anonymous"></script>
<script>
  Sentry.init({ dsn: '{{ env('SENTRY_DSN') }}' });
</script>
@endif
