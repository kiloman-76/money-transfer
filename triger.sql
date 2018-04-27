CREATE FUNCTION public.notifications_main()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
    IF (NEW.nt_read = TRUE AND NEW.nt_view > 0) THEN
        
    end if;
$BODY$;

ALTER FUNCTION public.notifications_main()
    OWNER TO postgres;