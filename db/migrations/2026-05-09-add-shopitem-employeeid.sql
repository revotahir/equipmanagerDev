ALTER TABLE shopitem
ADD COLUMN employeeID INT NULL AFTER userID;

ALTER TABLE shopitem
ADD CONSTRAINT fk_shopitem_employee
FOREIGN KEY (employeeID) REFERENCES users(userID)
ON DELETE SET NULL;

CREATE INDEX idx_shopitem_employee ON shopitem(employeeID, companyID);

UPDATE shopitem
SET employeeID = NULL
WHERE employeeID IS NOT NULL;
