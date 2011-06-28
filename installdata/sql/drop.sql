# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v5.2.2                     #
# Target DBMS:           MySQL 4                                         #
# Project file:          db.dez                                          #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2011-03-15 13:32                                #
# Model version:         Version 2011-03-15 3                            #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE SalesChannelOrder DROP FOREIGN KEY SalesChannel_SalesChannelOrder;

ALTER TABLE SalesChannelOrder DROP FOREIGN KEY CustomerOrder_SalesChannelOrder;

# ---------------------------------------------------------------------- #
# Drop table "SalesChannel"                                              #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE SalesChannel MODIFY ID INTEGER UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE SalesChannel DROP PRIMARY KEY;

# Drop table #

DROP TABLE SalesChannel;

# ---------------------------------------------------------------------- #
# Drop table "SalesChannelOrder"                                         #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE SalesChannelOrder MODIFY ID INTEGER NOT NULL;

# Drop constraints #

ALTER TABLE SalesChannelOrder DROP PRIMARY KEY;

# Drop table #

DROP TABLE SalesChannelOrder;