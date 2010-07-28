DROP DATABASE IF EXISTS whube;
CREATE DATABASE whube;
use whube;

CREATE TABLE users (
	uID            INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	real_name      VARCHAR(255),
	username       VARCHAR(255) UNIQUE,
	email          VARCHAR(255),
	locale         VARCHAR(8),
	timezone       VARCHAR(8),
	password       VARCHAR(255), /* HASHED, DUH */
	remotepw       VARCHAR(255), /* NOT HASHED! USED FOR INSECURE AUTH */
	startstamp     LONG,
	trampstamp     LONG,
	private        BOOL DEFAULT FALSE,
	PRIMARY KEY( uID )
);

INSERT INTO users VALUES (
	'',
	'Paul Tagliamonte',
	'paultag',
	'paultag@gmail.com',
	'EN',
	'-0500',
	'ae2b1fca515949e5d54fb22b8ed95575',
	'foo',
	1234567890,
	1234567890,
	FALSE
);

CREATE TABLE user_rights ( 
	userID         INTEGER NOT NULL, /* FK, users */
	admin          BOOL,
	staff          BOOL,
	doner          BOOL,
	member         BOOL,
	banned         BOOL,
	PRIMARY KEY( userID )
);

INSERT INTO user_rights VALUES (
	'1',
	TRUE, /* ADMIN */
	TRUE, /* STAFF */
	TRUE, /* DONER */
	TRUE, /* MEMBR */
	FALSE /* BANNED */
);

CREATE TABLE projects ( 
	pID            INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	project_name   VARCHAR(255) UNIQUE, /* like an alias */
	descr          TEXT,
	owner          INTEGER NOT NULL, /* FK, users */
	active         BOOL,
	startstamp     LONG,
	trampstamp     LONG,
	private        BOOL DEFAULT FALSE,
	PRIMARY KEY( pID )
);

INSERT INTO projects VALUES (
	'',
	'whube',
	'Whube is this project right here!',
	1,
	TRUE,
	1234567890,
	1234567890,
	FALSE
);

CREATE TABLE project_members (
	membershipID   INTEGER NOT NULL AUTO_INCREMENT,
	projectID      INTEGER NOT NULL,
	userID         INTEGER NOT NULL,
	active         BOOL,
	startstamp     LONG,
	trampstamp     LONG,
	PRIMARY KEY( membershipID )
);

INSERT INTO project_members VALUES (
	'',
	'1',
	'1',
	1234567890,
	1234567890,
	TRUE
);

CREATE TABLE status (
	statusID       INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	status_name    VARCHAR(255),
	critical       BOOL,
	PRIMARY KEY( statusID )
);

INSERT INTO status VALUES ( '', 'New',                       TRUE  ); /* status 1 ftw */
INSERT INTO status VALUES ( '', 'Bullcrap',                  FALSE );
INSERT INTO status VALUES ( '', 'Ass is awaiting a kicking', TRUE );
INSERT INTO status VALUES ( '', 'Reproduced',                TRUE  );
INSERT INTO status VALUES ( '', 'Something to Look at',      TRUE );
INSERT INTO status VALUES ( '', 'KICKING BUG ASS',           TRUE  );
INSERT INTO status VALUES ( '', 'Ass kicked',                FALSE );
INSERT INTO status VALUES ( '', 'Fix Released',              FALSE );

CREATE TABLE severity (
	severityID     INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	severity_name  VARCHAR(255),
	critical       VARCHAR(255),
	PRIMARY KEY( severityID )
);

INSERT INTO severity VALUES ( '', 'New',       TRUE );
INSERT INTO severity VALUES ( '', 'Wishlist',  FALSE );
INSERT INTO severity VALUES ( '', 'Low',       FALSE );
INSERT INTO severity VALUES ( '', 'Medium',    TRUE );
INSERT INTO severity VALUES ( '', 'High',      TRUE );
INSERT INTO severity VALUES ( '', 'Critical',  TRUE );
INSERT INTO severity VALUES ( '', 'OMGWTFBBQ', TRUE );

CREATE TABLE bugs ( 
	bID            INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	bug_status     INTEGER NOT NULL DEFAULT 1, /* FK, status */
	bug_severity   INTEGER NOT NULL DEFAULT 1, /* FK, severity */
	package        INTEGER NOT NULL, /* FK, project */
	reporter       INTEGER NOT NULL, /* FK, users */
	owner          INTEGER NOT NULL, /* FK, users */
	title          VARCHAR(255),
	descr          TEXT,
	startstamp     LONG,
	trampstamp     LONG,
	private        BOOL DEFAULT FALSE,
	PRIMARY KEY ( bID )
);

CREATE TABLE comment_classes (
	cClassID       INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	cClassAlias    VARCHAR(255),
	cClassTable    VARCHAR(255),
	startstamp     LONG,
	trampstamp     LONG,
	private        BOOL DEFAULT FALSE,
	PRIMARY KEY(cClassID)
);

CREATE TABLE comments (
	cID            INTEGER NOT NULL AUTO_INCREMENT, /* PK */
	cClass         INTEGER NOT NULL, /* FK, comment_classes */
	cClassID       INTEGER NOT NULL, /* FK, whatever table */
	cOwner         INTEGER NOT NULL, /* FK, users */
	cText          TEXT,
	startstamp     LONG,
	trampstamp     LONG,
	private        BOOL DEFAULT FALSE,
	PRIMARY KEY (cID)    
);

CREATE TABLE cache (
	cache_id           VARCHAR(25),
	timestamp          LONG /* DONG */,
	cached_contents    TEXT,
	PRIMARY KEY ( cache_id )
);

INSERT INTO cache VALUES ( 'tweeter', '', '' );

