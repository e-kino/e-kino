
ALTER TABLE booking DROP FOREIGN KEY fk_booking_showing1;

ALTER TABLE showing MODIFY id int(11) NOT NULL;
ALTER TABLE showing DROP PRIMARY KEY;
ALTER TABLE showing ADD PRIMARY KEY (id);
ALTER TABLE showing MODIFY id int(11) AUTO_INCREMENT NOT NULL;

ALTER TABLE booking
  ADD CONSTRAINT booking_showing_id_fk
FOREIGN KEY (showing_id) REFERENCES showing (id) ON DELETE CASCADE ON UPDATE CASCADE;