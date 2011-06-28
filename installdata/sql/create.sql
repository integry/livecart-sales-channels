# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v5.2.2                     #
# Target DBMS:           MySQL 4                                         #
# Project file:          db.dez                                          #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2011-03-15 13:32                                #
# Model version:         Version 2011-03-15 3                            #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "SalesChannel"                                               #
# ---------------------------------------------------------------------- #

CREATE TABLE SalesChannel (
    ID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255),
    keywords MEDIUMTEXT,
    referers MEDIUMTEXT,
    CONSTRAINT PK_SalesChannel PRIMARY KEY (ID)
)
ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;;

# ---------------------------------------------------------------------- #
# Add table "SalesChannelOrder"                                          #
# ---------------------------------------------------------------------- #

CREATE TABLE SalesChannelOrder (
    ID INTEGER NOT NULL AUTO_INCREMENT,
    orderID INTEGER UNSIGNED,
    channelID INTEGER UNSIGNED,
    date DATETIME,
    keyword VARCHAR(255),
    referer VARCHAR(255),
    CONSTRAINT PK_SalesChannelOrder PRIMARY KEY (ID)
)
ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;;


# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE SalesChannelOrder ADD CONSTRAINT SalesChannel_SalesChannelOrder
    FOREIGN KEY (channelID) REFERENCES SalesChannel (ID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE SalesChannelOrder ADD CONSTRAINT CustomerOrder_SalesChannelOrder
    FOREIGN KEY (orderID) REFERENCES CustomerOrder (ID) ON DELETE CASCADE ON UPDATE CASCADE;
