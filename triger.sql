CREATE FUNCTION public.notifications_main()
    RETURNS trigger
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE NOT LEAKPROOF
AS $BODY$
    BEGIN
    IF (NEW.nt_read = TRUE AND NEW.nt_view > 0) THEN
        INSERT INTO NotificationsArchive VALUES (NEW.*);
    ELSE
        INSERT INTO NotificationsActual VALUES (NEW.*);
        
    END IF;
    RETURN NULL;
    END;

$BODY$;

ALTER FUNCTION public.notifications_main()
    OWNER TO postgres;