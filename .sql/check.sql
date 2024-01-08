SELECT id, created_at
, document_uri
, effective_directive
, violated_directive
, disposition
, status_code
, blocked_uri
, referrer

FROM public.csp_reports;