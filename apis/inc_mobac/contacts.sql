


clients: id, name, email, password, mobile, location, date


contacts : id, client_id, displayName, name, nickname, birthday, note, creation, status, location

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `client_id` int(14) NOT NULL,
  `displayName` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `note` varchar(100) NOT NULL,
  `creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(2) NOT NULL DEFAULT '0',
  `location` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

phoneNumbers: id, contact_id, phone_number, creation

emails: id, contact_id, email, creation

addresses: id, contact_id, address, creation

ims: id, contact_id, im_address, creation

organizations: id, contact_id, company, job_title, creation,

photos: id, contact_id, img_url, creation,

categories: 



			id: A globally unique identifier. (DOMString)
			
			displayName: The name of this Contact, suitable for display to end-users. (DOMString)
			
			name: An object containing all components of a persons name. (ContactName)
			
			nickname: A casual name to address the contact by. (DOMString)

		phoneNumbers: An array of all the contact's phone numbers. (ContactField[])

		emails: An array of all the contact's email addresses. (ContactField[])
		
		addresses: An array of all the contact's addresses. (ContactAddress[])

		ims: An array of all the contact's IM addresses. (ContactField[])
		
		organizations: An array of all the contact's organizations. (ContactOrganization[])

			birthday: The birthday of the contact. (Date)
	
			note: A note about the contact. (DOMString)
		
		photos: An array of the contact's photos. (ContactField[])
		
		categories: An array of all the contacts user defined categories. (ContactField[])
