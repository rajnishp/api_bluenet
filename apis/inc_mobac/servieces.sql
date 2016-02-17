name": "Security Guard",
                "img": "http://blueteam.in/static/images/securityguard.jpeg",
                "status": 1,
                "plans": [
                    {
                        "name": "On-Demand",
                        "price": "129 Rs/hr"
                    },
                    {
                        "name": "Monthly",
                        "price": "69 Rs/hr"
                    },
                    {
                        "name": "Weekly",
                        "price": "89 Rs/hr"
                    }
                ],
                "addedon": null,
                "last_updated": null
            },


            services: { id, name, img, plans, status, creation_time, last_updated }


            CREATE TABLE IF NOT EXISTS `services` (
              `id` int(20) NOT NULL AUTO_INCREMENT,
              `name` varchar(15) NOT NULL,
              `img_url` varchar(50) NOT NULL,
              `plans` varchar(600) NOT NULL,
              `status` int(2) NOT NULL,
              `creation_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,              
              `last_updated` TIMESTAMP,              
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;