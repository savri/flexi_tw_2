-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 24, 2013 at 11:53 PM
-- Server version: 5.6.3
-- PHP Version: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Flexi-tw`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(16) NOT NULL,
  `answerId` char(36) NOT NULL COMMENT 'New system assigned UUID for the answer choices',
  `answerValue` varchar(500) NOT NULL COMMENT 'actual text of the answer',
  `answerTag` enum('CORRECT','CARELESS','OTHER','OOB') NOT NULL DEFAULT 'OTHER',
  PRIMARY KEY (`rowCounter`),
  KEY `questionId` (`questionId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=808 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`rowCounter`, `questionId`, `answerId`, `answerValue`, `answerTag`) VALUES
(2, 1, '110bdc35-6679-49a2-8001-6d4fbb1ccee0', '<p>refuse</p>', 'CORRECT'),
(3, 1, 'c3d337bc-0613-42ae-87a1-d91056ef72a2', '<p>confine</p>', 'OTHER'),
(4, 1, '44ece8ae-1da8-4640-96cd-03115fd6ef20', '<p>label</p>', 'OTHER'),
(5, 1, '6c7b4778-3f32-4a47-adfb-d7f214ff73e7', '<p>damage</p>', 'CARELESS'),
(6, 2, '08df7608-4345-4226-b325-2f921e4b32b3', '<p>annoy</p>', 'CORRECT'),
(7, 2, 'bdb70e91-aa9e-4c5d-bfaf-588ee3e7a56f', '<p>agree</p>', 'OTHER'),
(8, 2, '92f89e4e-e301-4fc0-b6e0-e471f4c32551', '<p>anger\n</p>', 'OTHER'),
(9, 2, '392fbe7d-dc01-4c44-ace8-8cd5f16fb013', '<p>defy</p>', 'OTHER'),
(10, 3, '90664f42-29cf-4b5a-9d72-829b155bc546', '<p>nourishing</p>', 'CORRECT'),
(11, 3, '2ea1df0a-b05c-4d81-92ab-bcbc94cda626', '<p>attentive</p>', 'OTHER'),
(12, 3, '72fecea5-1e45-406b-a7c2-45db4baae4df', '<p>spicy</p>', 'OTHER'),
(13, 3, 'f01d30df-9ce8-441c-ae08-f4d35bb8ea37', '<p>dangerous</p>', 'OTHER'),
(14, 4, 'eba1cb31-6d0e-4d1f-9fe6-3003bf28e976', '<p>restore</p>', 'CORRECT'),
(15, 4, 'cd3521ca-1f2e-4cbf-a5e4-5bdbcf835db0', '<p>prepare</p>', 'CARELESS'),
(16, 5, '7e2c2d7b-5a2c-46b9-9eb8-ad16ec7a1dbe', '<p>excellent</p>', 'CORRECT'),
(17, 5, 'e6990c53-9843-45dd-a39c-623c888caa39', '<p>happy</p>', 'OTHER'),
(18, 5, '2fa97dad-2baf-4561-9ea4-5d48b4bdfa99', '<p>puzzling</p>', 'OTHER'),
(19, 5, '92a7f73d-a433-4e07-8e73-2a2afcbb4e6b', '<p>spirited</p>', 'OTHER'),
(20, 6, '920a4f1a-dbdf-4f83-9300-669f886bcc02', '<p>speck</p>', 'CORRECT'),
(21, 6, 'e9834ca0-3148-488e-8a25-02202bf07532', '<p>quality</p>', 'OTHER'),
(22, 7, '2be774e9-a905-4223-919d-cbc7d262466c', '<p>original</p>', 'CORRECT'),
(23, 7, '7eac8566-82e4-4726-9f9b-ad29deb520a6', '<p>cheerful</p>', 'OTHER'),
(24, 7, '817eacea-9208-439b-9095-05a9cec998ae', '<p>false</p>', 'OTHER'),
(25, 7, '442ec11e-6fc0-487b-854c-2181c3382fad', '<p>perfect</p>', 'OTHER'),
(26, 8, 'af64397c-4903-490e-acc6-61861cd4b8ff', '<p>lengthen</p>', 'CORRECT'),
(27, 8, 'b86bdafa-36c1-4094-afd1-41fd54144fce', '<p>bruise</p>', 'OTHER'),
(28, 8, '2fdec313-ac2d-4ca0-b6a0-25118d3414d0', '<p>calculate</p>', 'OTHER'),
(29, 8, '2bc32821-e4b7-43a6-8d7c-f3e5f970caf3', '<p>moisten</p>', 'OTHER'),
(30, 9, 'a81c6cab-7f40-4566-8d8d-439bf3f7d824', '<p>seriously</p>', 'CORRECT'),
(31, 9, '36d0966e-befa-481f-bad1-698f9b49ce74', '<p>curiously</p>', 'OTHER'),
(32, 9, 'c525bf33-1270-47ef-ab15-8fbd3cb1a908', '<p>harmfully</p>', 'OTHER'),
(33, 9, '11b99487-e865-4b75-97e7-5e4999b693cd', '<p>possessively</p>', 'OTHER'),
(34, 10, 'bef514df-de05-473c-b7ca-31b20bfadf39', '<p>remove</p>', 'CORRECT'),
(35, 10, 'c2ed699d-0586-41f8-bb5e-468016525cac', '<p>guarantee</p>', 'OTHER'),
(36, 10, '59aab7f9-247f-4432-bc38-d71ea4e87789', '<p>rebel</p>', 'OTHER'),
(37, 10, 'a19b9543-b7ab-451d-b88f-7b73a3d168a1', '<p>salvage</p>', 'OTHER'),
(38, 11, '26fb21dc-b625-4863-9495-ffd4dd238a11', '<p>rarely</p>', 'CORRECT'),
(39, 11, '46743ad8-7bb4-49f3-acb9-840e13e6d76c', '<p>equally</p>', 'OTHER'),
(40, 11, '9efa2550-de7b-4aa7-9b79-45df8a31f4b7', '<p>naturally</p>', 'OTHER'),
(41, 11, '267d2cf5-c40a-4fb2-9463-3d9636353c19', '<p>quietly</p>', 'OTHER'),
(42, 13, '146e8471-11a9-4258-96ff-07fb6940db70', '<p>free</p>', 'CORRECT'),
(43, 13, '9a058f34-824e-4216-82ec-94a708eafe64', '<p>combine</p>', 'OTHER'),
(44, 13, '04da9e38-8249-4ac1-8567-947b07fe6e58', '<p>judge</p>', 'OTHER'),
(45, 13, 'ca27bd87-7e8d-4151-bec3-27a302efcc79', '<p>obtain</p>', 'OTHER'),
(46, 12, '6db4a86a-2639-49ef-bb01-729c12be3756', '<p>\n	sticky</p>\n ', 'CORRECT'),
(47, 12, 'c426786d-70c7-4bca-8030-008c54891580', '<p>\n	blunt</p>\n ', 'OTHER'),
(48, 12, '11ab3ad8-b003-4c49-b82f-84832f983991', '<p>\n	infectious</p>\n ', 'OTHER'),
(49, 12, '2caf1321-4a88-4aa7-a723-d4b122e2de23', '<p>\n	lukewarm</p>\n ', 'OTHER'),
(50, 14, '11b72d9c-a18f-42ff-8b16-b35d504a1a01', '<p>opinion</p>', 'CORRECT'),
(51, 14, 'ed57ed57-c9fe-442c-b285-4d42ab8957d3', '<p>contradiction</p>', 'OTHER'),
(52, 14, 'ff3554d6-53d3-4e07-8f33-7a1e3b0976fa', '<p>factor</p>', 'OTHER'),
(53, 14, '53a8e84e-0922-4716-9de0-23f9e13a7085', '<p>idealism</p>', 'OTHER'),
(54, 15, '971df657-2aad-45d0-9bd3-1dda379dae40', '<p>watchfullness</p>', 'CORRECT'),
(55, 15, 'dbc1e838-7cc5-447d-aba5-f8112efe205b', '<p>enthusiasm</p>', 'OTHER'),
(56, 15, 'baf15977-0c94-4c39-81dc-edac8b68744e', '<p>fury</p>', 'OTHER'),
(57, 15, '55f096eb-1137-4ec0-8b98-489c0ec2f2a0', '<p>importance</p>', 'OTHER'),
(58, 16, '144aba48-61ad-4e6f-a2cd-623a1f52cc91', '<p>attracts</p>', 'CORRECT'),
(59, 16, 'cd58cdd1-5a44-49e4-96c0-c30fc2aece24', '<p>conceals</p>', 'OTHER'),
(60, 16, '855cfa44-6e3d-4e62-8506-30a1b4bc0fdb', '<p>restrains</p>', 'OTHER'),
(61, 16, 'ff437810-dc5b-4799-a341-ba23a39cb618', '<p>threatens</p>', 'OTHER'),
(62, 17, 'c2bae662-3bad-4599-84d1-aa2becf91887', '<p>common</p>', 'CORRECT'),
(63, 17, '79cafb63-e8c8-438a-b349-fa5485ad4edf', '<p>imaginary</p>', 'OTHER'),
(64, 17, '3fba3687-d8d1-42a0-a548-0c0f62aeb517', '<p>scarce</p>', 'OTHER'),
(65, 17, '5064bab0-de7a-43a3-bd64-f87daf22365c', '<p>unknown</p>', 'OTHER'),
(66, 18, '8c2e2b79-e1bc-4ec4-87b1-78dcc6ee36cb', '<p>hazards</p>', 'CORRECT'),
(67, 18, '86d02dc8-2238-4453-8988-0b85582ba486', '<p>allies</p>', 'OTHER'),
(68, 18, '29196b44-2546-462d-80d9-6f96b0e40e9b', '<p>destinations</p>', 'OTHER'),
(69, 18, '60dc3758-337b-4c69-a7ad-214bf8aa2902', '<p>voyages</p>', 'OTHER'),
(70, 19, '666028db-06e4-4e3a-96c9-68c08ebc829c', '<p>countryside</p>', 'CORRECT'),
(71, 19, '3d5f4cfc-a7ae-4c9d-b4ac-1c662c72377a', '<p>deserts</p>', 'OTHER'),
(72, 19, 'adac9937-a5c3-47a2-85c6-57e18fc69dff', '<p>museums</p>', 'OTHER'),
(73, 19, 'f0040a65-0139-459c-b3f6-2686cc7b0900', '<p>towns</p>', 'OTHER'),
(74, 20, '9c3ec5b3-4dda-4d67-9517-a0d060147f52', '<p>devotion</p>', 'CORRECT'),
(75, 20, '8e0a9483-b82b-4e2b-b970-83c2d34434c7', '<p>fear</p>', 'OTHER'),
(76, 20, 'd0fe61cd-bbf8-4f30-b446-23a9a7386f5e', '<p>humor</p>', 'OTHER'),
(77, 20, '21e61bea-429c-446d-b099-0a7810d69afb', '<p>scorn</p>', 'OTHER'),
(78, 21, '8d9fbe8e-847d-41d9-a6fc-af94674f8d75', '<p>prevent</p>', 'CORRECT'),
(79, 21, 'd4baa321-a102-4533-a195-ac8b799846f3', '<p>distort</p>', 'OTHER'),
(80, 21, 'f0948820-e4f5-41d5-97bc-811aeb7a5762', '<p>eliminate</p>', 'OTHER'),
(81, 21, '9e4a3757-75f8-4c66-99e4-5cf18d30d051', '<p>manage</p>', 'OTHER'),
(82, 22, 'fca8a005-1c77-478e-aaad-aa30e1db5b88', '<p>tragedies</p>', 'CORRECT'),
(83, 22, 'afabdf47-7929-4429-b9fd-4605cc46e3fa', '<p>farces</p>', 'OTHER'),
(84, 22, 'df93bf26-cf29-487d-a2e5-3d04097467da', '<p>speeches</p>', 'OTHER'),
(85, 22, '933e84d5-5460-4bdd-9cf5-b9f40a67e756', '<p>daydreams</p>', 'OTHER'),
(86, 23, '95285d52-f401-4119-9e1c-c04b5cb1d39f', '<p>diversity</p>', 'CORRECT'),
(87, 23, 'a4df076a-a376-48d8-9526-524831b04286', '<p>control</p>', 'OTHER'),
(88, 23, 'a078d6bb-d6cd-4468-8314-46dae38bda56', '<p>disappearance</p>', 'OTHER'),
(89, 23, 'b908ec5e-41c7-4ae4-93ae-0cdd9f95f108', '<p>magnification</p>', 'OTHER'),
(90, 24, '60532c5a-d1be-4f16-8289-14f957466598', '<p>primary</p>', 'CORRECT'),
(91, 24, 'aee956a4-e8a7-474b-92c3-24bec4188d4e', '<p>detrimental</p>', 'OTHER'),
(92, 24, '506f2108-f4cc-4969-84c3-a591b160f426', '<p>sentimental</p>', 'OTHER'),
(93, 24, '866d960a-8ade-45b5-92dd-a3a2d92dd368', '<p>temporary</p>', 'OTHER'),
(94, 25, '5bac81c1-703f-4450-9252-e10ead13c370', '<p>widespread</p>', 'CORRECT'),
(95, 25, 'e5ecfdb3-e3e3-4fbb-b3bf-685548374275', '<p>attractive</p>', 'OTHER'),
(96, 25, 'b8d0ff34-e851-48ff-987e-daee26d9d72e', '<p>threatened</p>', 'OTHER'),
(97, 25, '21e19efc-a86f-4f7e-bcb1-e9fb38151af7', '<p>unknown</p>', 'OTHER'),
(98, 26, 'db74957f-c483-4b65-9993-41fe05b861bf', '<p>started painting when she was past seventy years old</p>', 'CORRECT'),
(99, 26, '853415f5-0ed1-4cb4-835e-4032efc27e05', '<p> painted for profit as a young child</p>', 'OTHER'),
(100, 26, '8c986117-5696-4dbf-86a7-c11f0fce3cbf', '<p>did not like art during her advanced years</p>', 'OTHER'),
(101, 26, 'ab1c08bd-0952-4d9d-ae22-dc12002a56bc', '<p>specialized in farm scenes and country landscapes</p>', 'OTHER'),
(102, 27, 'cac81304-bfc8-4b97-b9fc-cfc6c9360dae', '<p>teacher repeated the directions</p>', 'CORRECT'),
(103, 27, '79afac9e-af89-4864-bb54-de58bdf56c8d', '<p>faces became quite cold</p>', 'OTHER'),
(104, 27, 'dade664b-5528-43f7-a7df-89c11fc11176', '<p>classmates began to arrive</p>', 'OTHER'),
(105, 27, '6455ed7c-0075-498e-8422-566a7aa9f4d8', '<p>friend gave them a present</p>', 'OTHER'),
(106, 28, '9b7f5b75-3986-4838-a1d0-7a3646dedc2f', '<p>enjoy ourselves</p>', 'CORRECT'),
(107, 28, '170da905-1baf-4a88-aaf1-ebc44fcbf475', '<p>learn a lesson</p>', 'OTHER'),
(108, 28, '544b9059-1b14-4c9f-ba18-e03adda3da6e', '<p>examine our values</p>', 'OTHER'),
(109, 28, 'fea5c67f-a833-4ed0-9c8a-5318695711b4', '<p>improve our behavior</p>', 'OTHER'),
(110, 29, 'babd3741-e152-47fb-ab65-1b387580b175', '<p>was darker and of a more serious nature</p>', 'CORRECT'),
(111, 29, '6ebe2d93-e310-411b-812e-18eab187cb0b', '<p>sold successfully and made him rich</p>', 'OTHER'),
(112, 29, '4e5490f6-5c6c-4cc4-98e8-bf4856f20330', '<p>was appreciated by the critics but not the public</p>', 'OTHER'),
(113, 29, '2d2e4e22-4f66-4f2f-81b9-d1689aba0225', '<p>represented bright landscapes or people at play</p>', 'OTHER'),
(114, 30, '01b033c5-f630-40e3-922f-f474595aba61', '<p>did not appreciate their style of romantic music</p>', 'CORRECT'),
(115, 30, 'd912ccb1-3a2b-4438-97c9-cd15e106c48d', '<p>ignored them at every opportunity</p>', 'OTHER'),
(116, 30, '3b0be7e2-b262-4e0b-9ce4-90617e0d65cb', '<p>seldom gave large public performances</p>', 'OTHER'),
(117, 30, 'a8847f32-98e2-4d05-b7da-0b43a21cc3d6', '<p>turned out to be one of the most popular composers of his time</p>', 'OTHER'),
(118, 4, '1d3e890f-ae88-44e9-b03f-390c2744034c', '<p>regret</p>', 'OTHER'),
(119, 4, '2264c152-4111-49f0-9bc9-ae7911b4c6ad', '<p>simplify</p>', 'OTHER'),
(120, 6, 'eed35ba2-06b0-4d1a-90d9-4ccb6d9304b3', '<p>tone</p>', 'OTHER'),
(121, 6, '45f55e91-6b9c-429b-9c2c-55b64db07ba3', '<p>weight</p>', 'OTHER'),
(244, 45, '3890069e-4ca8-46b8-b9d1-2c66f8458337', '<p>\n	Enter Choice1</p>\n', 'CORRECT'),
(245, 45, '3890069e-4ca8-46b8-b9d1-2c66f8458337', '<p>\n	Enter Choice2</p>\n', 'CORRECT'),
(246, 45, '3890069e-4ca8-46b8-b9d1-2c66f8458337', '<p>\n	Enter Choice3</p>\n', 'CORRECT'),
(247, 45, '3890069e-4ca8-46b8-b9d1-2c66f8458337', '<p>\n	Enter Choice4</p>\n', 'CORRECT'),
(248, 46, 'd1f1a415-aa47-4dbc-802a-d866298c2864', '<p>\n	Enter Choice1</p>\n', 'CORRECT'),
(249, 46, 'd1f1a415-aa47-4dbc-802a-d866298c2864', '<p>\n	Enter Choice2</p>\n', 'CORRECT'),
(250, 46, 'd1f1a415-aa47-4dbc-802a-d866298c2864', '<p>\n	Enter Choice3</p>\n', 'CORRECT'),
(251, 46, 'd1f1a415-aa47-4dbc-802a-d866298c2864', '<p>\n	Enter Choice4</p>\n', 'CORRECT'),
(252, 47, 'f08f3ace-e145-46e8-86da-6ee2a0699aec', '<p>\n	Clarence</p>\n', 'CORRECT'),
(253, 47, '06616ebf-1d65-4a42-be0c-eda5dc20c31c', '<p>\n	Tabby</p>\n', 'OTHER'),
(254, 47, '4268f87a-7352-4b30-92e2-c13f32cf1593', '<p>\n	Bob</p>\n', 'OTHER'),
(255, 47, '87092f14-ccd6-4e9b-b94a-06978869e957', '<p>\n	Gobbelina</p>\n', 'OTHER'),
(256, 48, 'dbc6aec0-a1c1-41a5-80d0-e7904126da5b', '<p>\n	She is 4 years old</p>\n', 'OTHER'),
(257, 48, 'abdacb71-aa39-489e-aa54-32b3e5b9d7cd', '<p>\n	She is 87 years old.</p>\n', 'OTHER'),
(258, 48, '62322a4a-f9c6-4a50-8aa3-f02b58c929d4', '<p>\n	She is 5 days old</p>\n', 'OTHER'),
(259, 48, 'fd3a4c5e-ce1f-4f9b-a448-795601958625', '<p>\n	She is dead.</p>\n', 'CORRECT'),
(260, 49, 'b656d942-c89b-43d6-aba7-1e25ae9928fd', '<p>\n	Gravity</p>\n', 'OTHER'),
(261, 49, 'efe4e3a7-22a9-4a29-918c-16d45c2f8f20', '<p>\n	Will power</p>\n', 'CORRECT'),
(262, 49, '53f1471b-afe0-400d-9ec6-3f6a6f30fc9c', '<p>\n	Electricity</p>\n', 'OTHER'),
(263, 49, '41132bed-f72a-448c-ae18-e788d4959d2b', '<p>\n	Cheerios</p>\n', 'OTHER'),
(264, 50, '8e33b223-a7f5-4729-9679-e1bd4164be3c', '<p>\n	Life will return even to a vacant lot<br />\n	in the city.</p>\n', 'CORRECT'),
(265, 50, '358eaf69-ac15-4384-a73b-b4ee8b134937', '<p>\n	Animals will not live in a vacant lot<br />\n	until plant life has developed.</p>\n', 'OTHER'),
(266, 50, '2198fc20-892b-42f7-af21-0c88c03e7edf', '<p>\n	The clothing of people walking<br />\n	through the city carries plant seeds.</p>\n', 'OTHER'),
(267, 50, 'b9ceb83d-6d14-41d4-9767-edd11762e777', '<p>\n	Many buildings in London were<br />\n	destroyed by bombing during the<br />\n	Second World War.</p>\n', 'OTHER'),
(268, 51, 'f148c8a1-33d8-46bd-a5e1-5f3a87e3051a', '<p>\n	beautiful</p>\n', 'OTHER'),
(269, 51, '33482f8c-f967-4d5c-9e9b-81f55956998a', '<p>\n	edible</p>\n', 'OTHER'),
(270, 51, '81ff442b-c69d-4317-acf9-c730981b801d', '<p>\n	persistent</p>\n', 'CORRECT'),
(271, 51, '20a6014b-647d-41b2-bf87-56abc9c75854', '<p>\n	untidy</p>\n', 'OTHER'),
(272, 52, 'd4ec3d7c-dcf9-49b0-81c9-a5502ab540d4', '<p>\n	beautiful</p>\n ', 'OTHER'),
(273, 52, 'ea64a4a9-1089-4702-8e99-4b7cdd899eb8', '<p>\n	edible</p>\n ', 'OTHER'),
(274, 52, '268f6fa6-1180-49de-94ad-d44a1f71cd59', '<p>\n	persistent</p>\n ', 'CORRECT'),
(275, 52, '1ad3ae53-b4d5-4f20-af02-4748ae201ef6', '<p>\n	untidy</p>\n ', 'OTHER'),
(276, 53, 'a23a8d94-0d2c-455a-a7ce-e7dfb5f6d1de', '<p>\n	animal life disappeared from the<br />\n	area.</p>\n', 'OTHER'),
(277, 53, 'b20d162a-4b88-4bfd-99ae-4d3ab6db0b85', '<p>\n	people did not walk near or across<br />\n	the lot.</p>\n', 'OTHER'),
(278, 53, '7da95954-6d38-41c1-8228-d3c579b0699d', '<p>\n	the lot did not get enough water and<br />\n	sunlight.</p>\n', 'CORRECT'),
(279, 53, '4f1ea125-cee9-4f51-8aab-3c89bcc23db3', '<p>\n	the lot became covered with grasses<br />\n	and vines.</p>\n', 'OTHER'),
(280, 54, 'b27fad1c-da0b-4b44-94d5-049187fd55ba', '<p>\n	provide an exciting ending to the<br />\n	passage.</p>\n', 'OTHER'),
(281, 54, '50daded8-dba2-4e48-9879-324070963907', '<p>\n	provide an exciting ending to the<br />\n	passage.</p>\n', 'OTHER'),
(282, 54, '9ae4b594-0d04-465f-9ea0-dc10b1aa8461', '<p>\n	summarize one of the main ideas of<br />\n	the passage</p>\n', 'CORRECT'),
(283, 54, 'c0cba2a4-967c-47b5-99f7-389cc7691997', '<p>\n	provide evidence that the author&rsquo;s<br />\n	argument is correct.</p>\n', 'OTHER'),
(284, 55, '2fac3ad7-7392-427a-8af3-2f6a218a54e6', '<p>\n	the benefits of traveling by train.</p>\n', 'OTHER'),
(285, 55, '9e997dff-05d0-41e9-85e3-560b52f807bc', '<p>\n	the importance of visiting museums</p>\n', 'OTHER'),
(286, 55, '68664d38-9192-4c48-b594-e56f9abac08f', '<p>\n	the strengths and weaknesses of<br />\n	subway security.</p>\n', 'OTHER'),
(287, 55, '41d4a0bf-3bfb-45a9-9477-1d534a141dd4', '<p>\n	the teacher&rsquo;s experience with a<br />\n	group of students.</p>\n', 'CORRECT'),
(288, 56, '56ec26bc-34b4-40c0-b62b-27e9fc3deeb5', '<p>\n	called.</p>\n', 'OTHER'),
(289, 56, '462e5cc4-2b0b-42b3-90bc-8fa3360678cd', '<p>\n	continued.</p>\n', 'OTHER'),
(290, 56, '8ec54cb2-eeae-43f6-afb2-3d0f59e9a5e3', '<p>\n	gotten off.</p>\n', 'CORRECT'),
(291, 56, 'c624a8a5-710b-476c-ba5d-6bbaf8dd8208', '<p>\n	asked for help.</p>\n', 'OTHER'),
(292, 57, 'f71e3d5d-e832-4c8b-8e81-b81ab42bc423', '<p>\n	The students were bored and desired<br />\n	exercise.</p>\n', 'OTHER'),
(293, 57, '9e75c7e7-0b41-484a-96c7-c95e1a1f77a2', '<p>\n	The students were trying to find their<br />\n	lost classmates.</p>\n', 'OTHER'),
(294, 57, 'a9844633-c145-44d8-847d-273f5a1e878b', '<p>\n	The students who were not lost<br />\n	thought they should call 214.</p>\n', 'CORRECT'),
(295, 57, '858ea4bc-d4f3-4f18-89a7-064876496f5f', '<p>\n	The telephones on the subway<br />\n	platform</p>\n', 'OTHER'),
(296, 58, 'adec4018-016d-455b-9e58-b599d0f9a88a', '<p>\n	Where were the students going?</p>\n', 'CORRECT'),
(297, 58, '8085ac2c-4917-4c0d-9dab-dccc493e4191', '<p>\n	Where were the students coming<br />\n	from?</p>\n', 'OTHER'),
(298, 58, '1aeb7005-2ab7-421b-8695-e49d13af5a81', '<p>\n	How many students were in the total<br />\n	group?</p>\n', 'OTHER'),
(299, 58, '94783cf2-2f9e-420a-90a4-e999c8de3671', '<p>\n	How did the class react when the<br />\n	students were all reunited?</p>\n', 'OTHER'),
(300, 59, '5098901e-c21e-4e60-bca3-080c1a732dd6', '<p>\n	their teacher miscounted noses.</p>\n', 'OTHER'),
(301, 59, '3c1808f4-91a6-4b1e-9f08-ad6838f44c07', '<p>\n	the subway paging system was not<br />\n	working.</p>\n', 'OTHER'),
(302, 59, 'bdb42329-2e83-4396-bfbf-12f74b325f24', '<p>\n	they were distracted by the other<br />\n	passengers.</p>\n', 'OTHER'),
(303, 59, 'e42dff52-dba4-49a6-8f9f-213d2c05e917', '<p>\n	they were not in the same car as their<br />\n	teacher.</p>\n', 'CORRECT'),
(304, 60, '9b1b0be3-6623-4cae-ae48-c9233a200c3c', '<p>\n	Life will return even to a vacant lot in the city.</p>\n', 'CORRECT'),
(305, 60, '40713947-fdcf-46b2-ae2a-e7ac4a9cf43a', '<p>\n	Animals will not live in a vacant lot until plant life has developed.</p>\n', 'OTHER'),
(306, 60, '5bb152d8-9983-4e85-a192-119883cde8c1', '<p>\n	The clothing of people walking through the city carries plant seeds</p>\n', 'OTHER'),
(307, 60, 'ac0ed9bd-1f70-4871-8065-367ce4f9129e', '<p>\n	Many buildings in London were destroyed by bombing during the Second World War.</p>\n', 'OTHER'),
(308, 61, '38bc47af-9466-4e70-91fa-bd0e07a76274', '<p>\n	beautiful</p>\n', 'OTHER'),
(309, 61, '4081f04b-57f0-4261-8cff-35498e6e98bf', '<p>\n	edible</p>\n', 'OTHER'),
(310, 61, '4ff9f2a9-957a-4942-b81b-898f5dcb353a', '<p>\n	persistent</p>\n', 'CORRECT'),
(311, 61, '94b096cb-ac7d-45e1-a235-aab620f466cf', '<p>\n	untidy</p>\n', 'OTHER'),
(312, 62, '6f4b5650-f101-48ec-b3de-21887040b26b', '<p>\n	Enter Choice1</p>\n', 'OTHER'),
(313, 62, 'b7bb7fe0-a192-4616-93c5-cb85115a98ac', '<p>\n	Enter Choice2</p>\n', 'OTHER'),
(314, 62, '4af34a04-de24-4dfe-a29b-e83e166d5931', '<p>\n	Enter Choice3</p>\n', 'OTHER'),
(315, 62, 'f654c808-f111-46e1-b2eb-72d89d6cc924', '<p>\n	Enter Choice4</p>\n', 'OTHER'),
(316, 63, '3644e01a-3e25-40fe-a4ae-f8b41ef22e1f', '<p>\n	relate the various roles Frederick Douglas played in his lifetime.</p>\n', 'OTHER'),
(317, 63, '03632329-a250-46ca-bc92-57a954b9c18b', '<p>\n	analyze the reasons for the operation of the Underground Railroad.</p>\n', 'OTHER'),
(318, 63, '7be650bc-ad9c-4e90-851c-89c08e57f602', '<p>\n	describe Frederick Douglass&rsquo; work with the Underground Railroad.</p>\n', 'CORRECT'),
(319, 63, '31b39422-5951-4828-8aa9-744c28cab2ed', '<p>\n	discuss the characteristics of the slaves who used the Underground Railroad.</p>\n', 'OTHER'),
(320, 64, 'b1c9363f-db9a-4bc1-b0cd-674a07109b65', '<p>\n	conductors</p>\n', 'OTHER'),
(321, 64, '8592ed3e-a895-40cb-99f3-35d27133b38b', '<p>\n	engineers</p>\n', 'OTHER'),
(322, 64, '5b25e1ea-cd4e-4f58-9327-8a376b7ab58c', '<p>\n	passengers</p>\n', 'CORRECT'),
(323, 64, '13df9623-0001-4d8d-9662-754801e479cc', '<p>\n	stationmasters</p>\n', 'OTHER'),
(324, 65, '44ee56a1-9f56-48c3-a346-b50658bbdd5a', '<p>\n	escapee.</p>\n', 'CORRECT'),
(325, 65, '89a71783-01fd-487a-ba2c-5bb0965575d7', '<p>\n	immigrant.</p>\n', 'OTHER'),
(326, 65, 'ddce6737-ae30-44a0-947c-8988f4641efd', '<p>\n	pirate.</p>\n', 'OTHER'),
(327, 65, '2b0ed40c-0566-48f0-8170-88fbe85bb192', '<p>\n	wanderer.</p>\n', 'OTHER'),
(328, 66, '837e7792-e03b-42e7-a6f3-6a46916e14d3', '<p>\n	It became harder because fewer people worked with him.</p>\n', 'OTHER'),
(329, 66, 'dba3a77b-9f0e-4990-907c-73d69bc6f8fd', '<p>\n	It became more complicated because he had to involve his family.</p>\n', 'OTHER'),
(330, 66, '5c7484d0-042a-471a-8a9f-90b3b0215239', '<p>\n	It became more dangerous because, if caught, he could now go to prison.</p>\n', 'CORRECT'),
(331, 66, '341215dc-8891-4387-a8f7-c9267b64c577', '<p>\n	It became easier because more former masters came and retrieved the slaves.</p>\n', 'OTHER'),
(332, 67, 'cc8fbe36-ffb7-44ed-afd4-b49b84621dd4', '<p>\n	In which state did the Underground Railroad originate?</p>\n', 'OTHER'),
(333, 67, '66cfd4e4-179f-4364-be1e-03e9c9069afc', '<p>\n	What was Frederick Douglass&rsquo; work other than his work with slaves?</p>\n', 'OTHER'),
(334, 67, 'bf454d82-25e4-4711-9441-f7b9f88f6850', '<p>\n	Why did Frederick Douglass have his family members help him in his work?</p>\n', 'OTHER'),
(335, 67, 'c7e879da-fa34-4da3-8acc-d33fd6fd7e8f', '<p>\n	After 1850, what was the destination of most slaves on the Underground Railroad?</p>\n', 'CORRECT'),
(336, 68, 'eff10d88-5568-4fc3-8f1f-9b6e20c58362', '<p>\n	ants locate food and take it to their nests.</p>\n', 'OTHER'),
(337, 68, '074baad8-b988-48ad-8232-f226fae1921f', '<p>\n	ants find their way into people&rsquo;s homes.</p>\n', 'OTHER'),
(338, 68, '2abe2f4f-8e50-4cb1-b205-4a6e3906ff16', '<p>\n	the author learned about ants&rsquo; food preferences.</p>\n', 'CORRECT'),
(339, 68, '65632be6-1f65-4df5-949a-9ab003399724', '<p>\n	the author protects the kitchen against ants.</p>\n', 'OTHER'),
(340, 69, 'ef126a31-dfee-4c14-abc6-3a938ca80372', '<p>\n	annoyance.</p>\n', 'OTHER'),
(341, 69, '46b4057c-0d42-4e80-8899-10121408d7c3', '<p>\n	disgust.</p>\n', 'OTHER'),
(342, 69, 'a2c2e643-d393-4a33-8246-a5819f913cea', '<p>\n	dismay.</p>\n', 'OTHER'),
(343, 69, 'f76429fb-a8de-4c96-a6e1-06903ff322a6', '<p>\n	interest.</p>\n', 'CORRECT'),
(344, 70, '6110defd-9a09-47c7-8f7f-3b97ba4fcb11', '<p>\n	annoying.</p>\n', 'CORRECT'),
(345, 70, 'b1d6f25c-f284-4753-bad3-027d8e671e98', '<p>\n	dangerous.</p>\n', 'OTHER'),
(346, 70, 'd1f9097d-03b8-4068-85af-9c7739505308', '<p>\n	unappreciative.</p>\n', 'OTHER'),
(347, 70, '209bb74b-98b3-410d-b79f-fbe6a5c5e022', '<p>\n	unfriendly.</p>\n', 'OTHER'),
(348, 71, 'd6d561de-7b4e-4f91-a0a8-a300432af581', '<p>\n	build a nest</p>\n', 'OTHER'),
(349, 71, '156f417d-352a-446d-b6b0-f0733d62790f', '<p>\n	look for food.</p>\n', 'CORRECT'),
(350, 71, '2bc17e85-49fb-417a-8e9e-091582b3084f', '<p>\n	form a parade.</p>\n', 'OTHER'),
(351, 71, 'eecfd706-2080-47f1-a033-d2270d66ec91', '<p>\n	raise offspring.</p>\n', 'OTHER'),
(352, 72, '4021c57c-a749-4692-9736-75d1a0480004', '<p>\n	make the food visible from far away.</p>\n', 'OTHER'),
(353, 72, 'd82f3971-9868-467e-a3f8-c1640e1a60d6', '<p>\n	keep the food safe from other insects.</p>\n', 'OTHER'),
(354, 72, 'f8fd83ce-4817-4c8e-825c-73ec2acd62ce', '<p>\n	keep the ants from carrying the food away.</p>\n', 'OTHER'),
(355, 72, 'a23db35c-dbb1-4ba0-aa24-462bb6c6f6ab', '<p>\n	make it easier for the ants to climb onto it.</p>\n', 'CORRECT'),
(356, 73, 'f9e7ce3d-c566-41e9-a924-0033fbd8f4c3', '<p>\n	ans1</p>\n', 'OTHER'),
(357, 73, 'e177ed1b-808f-47fa-a5d3-647da1180096', '<p>\n	ans2</p>\n', 'CORRECT'),
(358, 73, '858308c5-9eea-46e1-ac29-1c0ca14ce476', '<p>\n	ans3</p>\n', 'OTHER'),
(359, 73, 'f3a6c6a8-97c1-44b5-95d9-3112aa73d189', '<p>\n	werwer</p>\n', 'OTHER'),
(360, 74, '47952a6a-2b05-49d9-94b5-f5c819dc3114', '<p>\n	<img alt="" src="a68ac894811b5fbc4e7cd194329e14cf.png</br>" style="width: 21px; height: 44px;" /></p>\n', 'CORRECT'),
(361, 74, '838b4c8c-75aa-49e8-a0a9-645371f5e762', '<p>\n	<img alt="" src="a5629f48db5573514dc2d3c984313121.png</br>" style="width: 21px; height: 44px;" /></p>\n', 'OTHER'),
(362, 74, '1c2064a8-64e8-410f-9b29-7097f3de3582', '<p>\n	<img alt="" src="6b64e3f1756ce85c83641331891aeb89.png</br>" style="width: 21px; height: 44px;" /></p>\n', 'OTHER'),
(363, 74, '2abd513d-1389-41e7-b0d4-c4779ac34545', '<p>\n	<img alt="" src="41891f5e8ace60c819a1c76af3792a55.png</br>" style="width: 22px; height: 46px;" /></p>\n', 'OTHER'),
(364, 75, '4e32b200-e9a7-4eb5-a34c-c88de11f6a36', '<p>\n	I have 35 cookies. After eating 5 cookies, how many cookies do I have left?</p>\n', 'OTHER'),
(365, 75, 'ca62d01b-c43d-4ba0-a9fc-5b9bdab7ffa0', '<p>\n	I want to share 35 cookies with 12 friends. How many cookies do we each get?</p>\n', 'OTHER'),
(366, 75, 'e444668d-42a8-47ca-bc37-da2dbe193c5c', '<p>\n	I have 7 boxes of cookies, with 5 cookies in each. How many cookies do I have altogether?</p>\n', 'CORRECT'),
(367, 75, 'ea482738-c287-40f3-bd8f-7758a2d7d014', '<p>\n	I have 7 boxes of cookies, and my friend has 5 boxes of cookies. How many boxes of cookies do we have altogether?</p>\n', 'OTHER'),
(368, 76, 'f35f3629-9f92-45e0-976f-4f84426f68a0', '<p>\n	7</p>\n', 'OTHER'),
(369, 76, '71ceb411-64a0-43a8-be43-762fb82202dd', '<p>\n	9</p>\n', 'CORRECT'),
(370, 76, 'f2ebee33-b1cd-428f-b1f9-77c1ae8bbc99', '<p>\n	10</p>\n', 'OTHER'),
(371, 76, '4f1d47ae-05a4-46ea-b622-b9561e63be77', '<p>\n	11</p>\n', 'OTHER'),
(372, 77, 'ec5d24f6-d70e-4d43-9328-77ae131974c3', '<p>\n	10 centimeters</p>\n', 'CORRECT'),
(373, 77, 'fcd580c2-7493-4469-9f18-abb2e01ed034', '<p>\n	18 centimeters</p>\n', 'OTHER'),
(374, 77, '8ed41fd3-02c2-4863-a6df-bfeebab34b37', '<p>\n	36 centimeters</p>\n', 'OTHER'),
(375, 77, '15634ec3-6c1d-4c88-bacf-eb629707c26f', '<p>\n	46 centimeters</p>\n', 'OTHER'),
(376, 78, 'd8999f3a-a1cd-4b4b-a7f4-d560963491cc', '<p>\n	9 units<sup>3</sup></p>\n ', 'CARELESS'),
(377, 78, '3c00940d-ba1c-4853-8a12-35515bc9bda9', '<p>\n	18 units<sup>3</sup></p>\n ', 'OTHER'),
(378, 78, '9e022cd8-3ed1-4cec-9c8b-3c540c1c0def', '<p>\n	27 units<sup>3</sup></p>\n ', 'CORRECT'),
(379, 78, 'ef3a4fc0-e8ba-4474-82bd-990d804a7e2e', '<p>\n	81 units<sup>3</sup></p>\n ', 'OTHER'),
(380, 79, '809edb49-9018-4805-bd97-64e53a50169a', '<p>\n	<img align="middle" src="3bee6d06cd4fd8472b0a2309a6ae5416.png" /></p>\n ', 'OTHER'),
(381, 79, '54e85d90-a055-448c-b1bc-66be2689bdea', '<p>\n	4</p>\n ', 'OTHER'),
(382, 79, 'bee9e1b7-c853-4a13-bfff-0066cd480661', '<p>\n	<img align="middle" src="4295959b8b22aedf6e76e559313f3ba5.png" /></p>\n ', 'CORRECT'),
(383, 79, 'a621a5f5-c6d5-4283-a42b-3527e06b693d', '<p>\n	5</p>\n ', 'OTHER'),
(384, 80, '4ae62781-4166-4739-a752-ddf4b04791b3', '<p>\n	48 minutes</p>\n', 'OTHER'),
(385, 80, 'db1880e6-431b-496a-b951-dd4ee1d1676f', '<p>\n	60 minutes</p>\n', 'CORRECT'),
(386, 80, '6ffe184e-92cd-4f72-ade8-6e7a0c181622', '<p>\n	80 minutes</p>\n', 'OTHER'),
(387, 80, '91b299e2-d9f3-4487-8608-dbb8dd7b2a4d', '<p>\n	120 minutes</p>\n', 'OTHER'),
(388, 81, '44107bde-0a4a-4f79-b71a-a370d856bf62', '<p>\n	<img align="middle" src="0a5d32857462aa279a7b5f00bcf0699e.png</br>" style="width: 21px; height: 44px;" /></p>\n', 'CORRECT'),
(389, 81, '850a9eae-cd0a-4bea-b8c4-0c6a2812b04e', '<p>\n	<img align="middle" src="f9c28b29396336cff3473c81be200bef.png</br>" style="width: 31px; height: 44px;" /></p>\n', 'OTHER'),
(390, 81, '4473c54d-43ba-4f5e-b39d-2356ef070e36', '<p>\n	<img align="middle" src="9e1863d22aa6bec416e7bed06cb9aeff.png</br>" style="width: 31px; height: 44px;" /></p>\n', 'OTHER'),
(391, 81, '6da382e8-f249-484d-bb06-20bbbdd9ff24', '<p>\n	<img alt="" src="3d40810ab4c489fe7e9e79325cff0ca5.png</br>" style="width: 31px; height: 44px;" /></p>\n', 'OTHER'),
(392, 82, 'af484f9e-8d34-4d09-a8f3-107ee2154c90', '<p>\n	2</p>\n', 'OTHER'),
(393, 82, '081fccf8-ee17-4a96-8160-b1c0a91f94b4', '<p>\n	8</p>\n', 'OTHER'),
(394, 82, '5cbe3898-87a4-4901-99c5-586450cbdd10', '<p>\n	10</p>\n', 'OTHER'),
(395, 82, 'a1f22d4f-5b7c-42c4-a89a-789403908a2d', '<p>\n	15</p>\n', 'CORRECT'),
(396, 83, 'b80818c7-1623-49f3-bc05-b877f2f82332', '<p>\n	a red square</p>\n', 'OTHER'),
(397, 83, 'c517ac0a-5376-494d-a53a-33d9bb907d10', '<p>\n	a blue square</p>\n', 'OTHER'),
(398, 83, 'f22e574c-c877-4e47-9dbd-48fbc798baf5', '<p>\n	a blue triangle</p>\n', 'OTHER'),
(399, 83, 'a8749a5b-352d-4805-a46e-92f376c28d18', '<p>\n	a green triangle</p>\n', 'CORRECT'),
(400, 84, '252fba82-b5e1-4d25-af93-8ce5f75afae1', '<p>\n	75<sup>o</sup>F</p>\n', 'OTHER'),
(401, 84, '8559212a-f1ae-46c2-ab7e-b0cedad90b76', '<p>\n	79<sup>o</sup>F</p>\n', 'OTHER'),
(402, 84, '8217d3e7-89fc-4a44-b49e-67ca84ee4fe4', '<p>\n	83<sup>o</sup>F</p>\n', 'CORRECT'),
(403, 84, '4bcfed01-de95-45f4-bcb6-12c56e4662f1', '<p>\n	92<sup>o</sup>F</p>\n', 'OTHER'),
(404, 85, 'ed1cd85a-8cdd-40da-8d34-f2bf57b4280e', '<p>\n	<img align="middle" src="8deed4d9103bb52de964f77c1b5c3b2e.png</br>" /></p>\n', 'OTHER'),
(405, 85, '6b75c5b8-3e36-44be-b8d9-26ee63c3d533', '<p>\n	<img align="middle" src="369e0052b6494811ab34d6b4b97266af.png</br>" /></p>\n', 'OTHER'),
(406, 85, 'b459138a-b231-4fac-905e-b75d6be6cd45', '<p>\n	<img align="middle" src="cca344852d11b41c143ecf91598a5abe.png</br>" /></p>\n', 'CORRECT'),
(407, 85, '8a7bb242-ada9-4f84-8625-e614fa8c0b20', '<p>\n	<img align="middle" src="53506c9434b0bf14f12bf4dac72516b1.png</br>" /></p>\n', 'OTHER'),
(408, 86, '8e9f7eaa-b2cd-458b-b531-0ce18e321f25', '<p>\n	2</p>\n', 'OTHER'),
(409, 86, 'dfbb6f09-6ebe-4ad9-9d22-64a7e5602a94', '<p>\n	3</p>\n', 'OTHER'),
(410, 86, 'a441a519-af6c-48c6-bbfe-3b76ea58240f', '<p>\n	2s</p>\n', 'CORRECT'),
(411, 86, 'a7553283-cabb-4e5e-b6d2-bd1a24337b6b', '<p>\n	4s</p>\n', 'OTHER'),
(412, 87, 'b6657f5c-a72f-4a1e-a1d0-9ef56818950b', '<p>\n	1</p>\n', 'OTHER'),
(413, 87, '74ca47fc-cd8c-4614-9133-c3404565fdd7', '<p>\n	2</p>\n', 'OTHER'),
(414, 87, 'f3343091-b5b5-49fa-b4ea-cfb916350e1c', '<p>\n	3</p>\n', 'OTHER'),
(415, 87, 'dcd28deb-e757-4cc4-82ca-2883c532f455', '<p>\n	4</p>\n', 'CORRECT'),
(416, 88, 'aced7ed8-29a3-495d-a46c-bf36099ded6c', '<p>\n	5</p>\n', 'OTHER'),
(417, 88, 'fcec7e79-03d8-4035-8cda-48f8ff0379d1', '<p>\n	7</p>\n', 'OTHER'),
(418, 88, '6c31220a-7f95-49a6-8e2f-17f4058a0037', '<p>\n	9</p>\n', 'OTHER'),
(419, 88, 'b1fc412f-cc05-41b0-b2e3-daeedf6b4eb2', '<p>\n	11</p>\n', 'CORRECT'),
(420, 89, '9008e209-9129-42ea-acc4-54a16a775bfd', '<p>\n	5<sup>2</sup></p>\n', 'OTHER'),
(421, 89, 'f02ca55b-2a83-4256-bc9b-0014dba3f782', '<p>\n	8<sup>2</sup></p>\n', 'CORRECT'),
(422, 89, '76d655db-d3cb-418b-a72e-08e871bd1ee1', '<p>\n    12<sup>2</sup></p>', 'OTHER'),
(423, 89, 'eb92cf09-a8c0-425c-9c0b-4b4c641ba0f5', '<p>\n	13<sup>2</sup></p>\n', 'OTHER'),
(424, 90, '23174812-277d-4dc2-9a7e-7cf988da0e53', '<p>\n	<img align="middle" src="01bab67773018c2b3408669cead29c32.png" /></p>\n ', 'OTHER'),
(425, 90, '530145ee-95e2-4f10-b8a5-07fc0bbf024d', '<p>\n	<img align="middle" src="e45fb853603445d589cf4c89245a08ef.png" /></p>\n ', 'OTHER'),
(426, 90, '20010504-ca80-4a12-9142-dac42c720920', '<p>\n	<img align="middle" src="985aac17ea173c42fae5ea3355f78426.png" /></p>\n ', 'OTHER'),
(427, 90, '15197d24-eef3-41e5-8672-c0e762a07b04', '<p>\n	<img align="middle" src="b91071fd17d2950bb637d63c131a93c1.png" /></p>\n ', 'OTHER'),
(428, 91, 'e74b7b56-93f5-4655-b6fc-156c2bc90112', '<p>\n	2 1/2 ounces</p>\n', 'OTHER'),
(429, 91, '96191493-fcb7-4c1a-99c3-163e971ea050', '<p>\n	2 3/4 ounces</p>\n', 'OTHER'),
(430, 91, '8b57ade2-1436-4f27-be1b-2157ffbe623e', '<p>\n	3 ounces</p>\n', 'CORRECT'),
(431, 91, '298a2b13-029d-4192-94ca-1e217e05e632', '<p>\n	4 ounces</p>\n', 'OTHER'),
(432, 92, '36167d49-bcaf-4913-a99b-70bf052b172f', '<p>\n	2.2, 2.4, 2.6</p>\n', 'OTHER'),
(433, 92, 'a777aa4d-9fc0-4b60-94c4-2f4344308fb9', '<p>\n	2.4, 2.8, 3.0</p>\n', 'OTHER'),
(434, 92, 'd708d2ac-fa97-4f25-9b90-344853480c1f', '<p>\n	2.6, 3.2, 3.8</p>\n', 'CORRECT'),
(435, 92, 'f93565e1-b364-43a1-9b18-47b3b6c0e6b5', '<p>\n	2.8, 3.6, 4.2</p>\n', 'OTHER'),
(436, 93, '1bc79859-4d21-44ac-b80d-4ca05a46ebdc', '<p>\n	<em>y &ndash; x</em></p>\n', 'OTHER'),
(437, 93, 'efea54c8-e870-4866-875d-1f48127ab0f7', '<p>\n	<em>y + x</em></p>\n', 'CORRECT'),
(438, 93, '291bc1ff-15cd-4505-9b64-a4fb4c47b8e7', '<p>\n	<em>x - y</em></p>\n', 'OTHER'),
(439, 93, 'd10ed14b-3590-4a36-ac72-2e62029928d2', '<p>\n	<em>xy</em></p>\n', 'OTHER'),
(440, 94, '29596a72-9f24-493c-8beb-aea19d81d2d1', '<p>\n	69 x 40</p>\n', 'OTHER'),
(441, 94, '08b239bd-5d6d-485e-bc3b-4f24f27e8150', '<p>\n	70 x 40</p>\n', 'OTHER'),
(442, 94, 'f7aafa4d-5a86-489f-a0a4-08e8c8193f5b', '<p>\n	600 x 30</p>\n', 'OTHER'),
(443, 94, '26617af6-a819-4955-93eb-d530bea481ec', '<p>\n	700 x 40</p>\n', 'CORRECT'),
(444, 95, '19fe3d53-1246-45e8-b0da-80b070b1ac8c', '<p>\n	9 units<sup>3</sup></p>\n', 'CARELESS'),
(445, 95, '7df86344-6801-4249-aaff-ec4676806949', '<p>\n	18 units<sup>3</sup></p>\n', 'OTHER'),
(446, 95, 'f0b35d14-08f4-40ca-afd6-1d5fecfe1ba8', '<p>\n	27 units<sup>3</sup></p>\n', 'CORRECT'),
(447, 95, '3be68f6b-5335-460b-95ea-cb8723818271', '<p>\n	81 units<sup>3</sup></p>\n', 'OTHER'),
(448, 96, '2f90caa0-de94-4764-bcfe-5c261aa8f173', '<p>\n	2/3 cup</p>\n', 'OTHER'),
(449, 96, 'b02146e6-b3c5-4ef8-9290-9349412118cc', '<p>\n	1.5 cups</p>\n', 'CORRECT'),
(450, 96, '52464bb6-fc22-4fb6-a73c-335613f1f765', '<p>\n	3 cups</p>\n', 'OTHER'),
(451, 96, '95b01b36-3362-4836-8566-87c6d3e84717', '<p>\n	6&nbsp; cups</p>\n', 'OTHER'),
(452, 97, '7bfc36ba-93e7-4f1f-8b02-d89dcc66d5f5', '<p>\n	line <em>p </em>only</p>\n', 'OTHER'),
(453, 97, '5927e77a-1aca-493c-8e53-afebea4f17dd', '<p>\n	line <em>s </em>only</p>\n', 'OTHER'),
(454, 97, 'f8714cc4-ac81-44b7-af1c-ccb995eb6b01', '<p>\n	both line <em>p</em> and line <em>s</em></p>\n', 'OTHER'),
(455, 97, '16b6606a-7651-46b6-8796-e378e5efe05d', '<p>\n	both line <em>p</em> and line <em>r</em></p>\n', 'CORRECT'),
(456, 98, 'c3543824-f65e-48ff-b9f0-e6abaa6588b7', '\n<p>\n	<img align="middle" src="3bee6d06cd4fd8472b0a2309a6ae5416.png</br>" /></p>', 'OTHER'),
(500, 109, 'da91b6f0-ed6f-4d9a-9ff8-9b9466ae9b49', '<p>\n	10 A.M</p>\n', 'OTHER'),
(501, 109, 'd8e435a3-0460-421b-ba7d-5ea6762a98e9', '<p>\n	1 P.M.</p>\n', 'OTHER'),
(457, 98, 'dae07e44-19a9-40d6-837b-764bca6bb308', '<p>\n	4</p>\n', 'OTHER'),
(458, 98, '1db3f2d7-58e6-4f85-ada0-60e59070deaf', '<p><img align="middle" src="4295959b8b22aedf6e76e559313f3ba5.png</br>" /></p>\n', 'CORRECT'),
(502, 109, 'f54fa398-c8d0-4ac6-b0bb-39568fa56846', '<p>\n	5 P.M.</p>\n', 'OTHER'),
(503, 109, '24e31c68-f4af-42a5-872a-eb58a46507ae', '<p>\n	8 P.M.</p>\n', 'CORRECT'),
(459, 98, '64f7c7ff-2072-4ec1-b229-1a85b76b1552', '<p>\n	5</p>\n', 'OTHER'),
(460, 99, 'edc1bcd0-5880-45f9-b2a0-6197dfbd646f', '<p>\n	2.5 inches</p>\n', 'OTHER'),
(461, 99, '35162331-a0a8-4265-8d51-a86c196d912e', '<p>\n	3.0 inches</p>\n', 'CORRECT'),
(462, 99, '48392d50-b569-407b-90c3-f3e49f258c4e', '<p>\n	3.5 inches</p>\n', 'OTHER'),
(463, 99, '2e7c50aa-48f7-477d-a90f-7832be2c8aa4', '<p>\n	3.7 inches</p>\n', 'OTHER'),
(464, 100, '92007c1c-9722-411b-97d9-afce7acb4a0c', '<p>\n	3</p>\n', 'OTHER'),
(465, 100, '3c21552a-8f02-4b39-9cf6-715c5432ebc0', '<p>\n	4</p>\n', 'OTHER'),
(466, 100, '820fb342-c8c0-4090-971b-2583d7985012', '<p>\n	9</p>\n', 'CORRECT'),
(467, 100, 'fc12ad54-2a01-43fb-8ecf-1690a495af74', '<p>\n	11</p>\n', 'OTHER'),
(468, 101, '92ba915b-67ab-4b5e-8118-445360f5f5af', '<p>\n	32</p>\n', 'OTHER'),
(469, 101, '011d12cf-742b-4316-9b99-c0eb0e0b21bd', '<p>\n	48</p>\n', 'OTHER'),
(470, 101, '6a0ac804-5c0d-411d-863e-23a08ff70f3e', '<p>\n	64</p>\n', 'CORRECT'),
(471, 101, '4fd59c17-c218-458f-8e7b-05a2fb9f7ee0', '<p>\n	96</p>\n', 'OTHER'),
(472, 102, 'c737a0bf-beb5-42a5-b126-eaac9c124cb8', '<p>\n	The mean is between 18 and 19.</p>\n', 'OTHER'),
(473, 102, '010b0af2-287c-42a5-b0d7-912cd3beda89', '<p>\n	Eric read fewer minutes than Mandy.</p>\n', 'OTHER'),
(474, 102, 'e601af7b-8605-49b6-8526-0a401fe89a59', '<p>\n	The range is greater than the number of minutes Joey read.</p>\n', 'CORRECT'),
(475, 102, 'f3c5855a-87f2-4a62-850e-654e570bd17c', '<p>\n	Lisa read the same number of minutes as Joey and Eric combined.</p>\n', 'OTHER'),
(476, 103, '4a8b9a4a-0a67-413d-bbff-e4436477174e', '<p>\n	2 + (6 &times; n) = 10 &ndash; n</p>\n', 'OTHER'),
(477, 103, '87dadd74-29b0-4c47-9e2a-f17a6ec03f7a', '<p>\n	2 + (6 &times; n) = n &ndash; 10</p>\n', 'CORRECT'),
(478, 103, '380543e5-b831-4daf-98f3-a324928e9dd9', '<p>\n	2 &times; (6 &times; n) = 10 &ndash; n</p>\n', 'OTHER'),
(479, 103, '090715f0-a457-4fc9-b810-65b5a6de0fa0', '<p>\n	2 &times; (6 &times; n) = n &ndash; 10</p>\n', 'OTHER'),
(480, 104, 'ded1555d-84dc-4b6c-a9d2-2d263f8e581c', '<p>\n	4</p>\n', 'CORRECT'),
(481, 104, '68e43b12-07dd-42ea-a7b5-fd46ccb7895a', '<p>\n	5</p>\n', 'OTHER'),
(482, 104, 'b6d3d727-d9d0-4e0c-af95-05e43a478c0e', '<p>\n	6</p>\n', 'OTHER'),
(483, 104, '996e5e67-7e46-4b17-8e76-6536166dc7fe', '<p>\n	7</p>\n', 'OTHER'),
(484, 105, '0ec2a953-de91-4ac8-ad6e-44913f4a5ca8', '<p>\n	4 caramel chocolates and 9 others</p>\n', 'CARELESS'),
(485, 105, '70d6e651-0c21-4063-b890-e9346df18ab1', '<p>\n	16 caramel chocolates and 36 others</p>\n', 'OTHER'),
(486, 105, '93461b5c-a70b-49c0-9c70-bb62bedccc18', '<p>\n	18 caramel chocolates and 8 others</p>\n', 'OTHER'),
(487, 105, 'fffa8e4e-6323-49b5-afd5-ab894e710852', '<p>\n	20 caramel chocolates and 25 others</p>\n', 'CORRECT'),
(488, 106, '0bcabd9c-73f5-45eb-993f-9dfb34d5ff58', '<p>\n	between 1,000 and 1,200</p>\n', 'OTHER'),
(489, 106, '5db6bf7e-d8a9-4c88-a308-043b67f508a2', '<p>\n	between 1,200 and 2,000</p>\n', 'CORRECT'),
(490, 106, 'eff1611c-f583-4758-9c16-86af446209e8', '<p>\n	between 2,000 and 2,500</p>\n', 'OTHER'),
(491, 106, 'f898665f-eb5e-4ba9-a90d-d5e6bbcc44ae', '<p>\n	between 2,500 and 3,000</p>\n', 'OTHER'),
(492, 107, '159e77f9-1d8d-4947-9152-ba75b0031e4c', '<p>\n	200</p>\n', 'OTHER'),
(493, 107, 'f42dac17-48e4-408e-b82c-85fb30c446c7', '<p>\n	600</p>\n', 'CORRECT'),
(494, 107, 'f028ad6e-9611-4472-b071-3f0097587bce', '<p>\n	900</p>\n', 'OTHER'),
(495, 107, 'a27a89d2-e069-4655-a089-692865c5dd21', '<p>\n	1,800</p>\n', 'OTHER'),
(496, 108, 'cb561c92-e87d-4cd5-8cfa-329bae4223b7', '<p>\n	3</p>\n', 'OTHER'),
(497, 108, 'b66cf857-fc04-4d14-af4a-b3a36b3ce4e6', '<p>\n	6</p>\n', 'OTHER'),
(498, 108, '44d51ef7-6cbd-4500-92ca-7f127b637b04', '<p>\n	14</p>\n', 'OTHER'),
(499, 108, '831d118d-b8af-4119-b5be-f72341167af3', '<p>\n	18</p>\n', 'CORRECT'),
(504, 110, '4e2c86ff-43ad-44d9-b854-281656c74f13', '<p>\n	<span style="font-size:12px;">18 feet</span></p>\n', 'OTHER'),
(505, 110, 'bbba315b-784a-4691-b0aa-ad166d3d6c2c', '<p>\n	36 feet</p>\n', 'CORRECT'),
(506, 110, 'fe30eac7-88f1-40ee-a394-72091976dd14', '<p>\n	<span style="font-size:12px;">54 feet</span></p>\n', 'OTHER'),
(507, 110, '16c8febd-9403-4ccb-8adc-f42879b1dce2', '<p>\n	<span style="font-size:12px;">72 feet</span></p>\n', 'OTHER'),
(508, 111, '94b0dd4d-1ff9-47e0-ac07-0dd49a4c6e15', '<p>\n	7</p>\n', 'CORRECT'),
(509, 111, '4e2738f1-f063-4cf8-885b-f0457eb30638', '<p>\n	11</p>\n', 'OTHER'),
(510, 111, 'b942e6d6-d0f7-46ef-a6a5-92d98e0bea68', '<p>\n	15</p>\n', 'OTHER'),
(511, 111, '9714aea8-f317-4050-90e6-468e5c9b74fe', '<p>\n	21</p>\n', 'OTHER'),
(512, 112, 'e7210be1-740f-49ff-a239-d857ca77ce62', '<p>\n	hexagon</p>\n', 'OTHER'),
(513, 112, 'ea992f88-2877-42fe-9b73-5785c11320aa', '<p>\n	octagon</p>\n', 'OTHER'),
(514, 112, '5eac46b5-20f8-4c86-bcf5-3fed7ac2a3b2', '<p>\n	pentagon</p>\n', 'OTHER'),
(515, 112, '75eb82e8-a72a-4d1f-8f10-0025fa1cde24', '<p>\n	square</p>\n', 'CORRECT'),
(516, 113, 'b6b2a2d8-915e-4709-bdc1-5e9ae60c4ae9', '<p>\n	203,049</p>\n', 'CORRECT'),
(517, 113, 'd000ebdf-224f-47c3-9bce-b93ad1819f7d', '<p>\n	203,409</p>\n', 'OTHER'),
(518, 113, 'd48c580b-0e6d-4224-beee-f7ff134d6b36', '<p>\n	230,490</p>\n', 'OTHER'),
(519, 113, '417a8c53-2fa3-46e0-8606-6b8134194cd7', '<p>\n	234,900</p>\n', 'OTHER'),
(520, 114, 'dfd15095-810e-403e-8615-b37e003178c8', '<p>\n	405</p>\n', 'OTHER'),
(521, 114, 'ebf6edd6-eb4c-4d45-8ba0-6bc22473aecf', '<p>\n	495</p>\n', 'OTHER'),
(522, 114, '1f159ec2-98e0-474d-872a-f212ad48f16d', '<p>\n	505</p>\n', 'CORRECT'),
(523, 114, '9f11bd09-f25d-44f9-829d-93d867dc097f', '<p>\n	515</p>\n', 'OTHER'),
(524, 115, 'd3acd808-2843-473e-aa4b-37f41e516e50', '<p>\n	(3 x 5) + 4 - 7</p>\n', 'OTHER'),
(525, 115, '530618cf-91d9-476d-b4ab-10cc556f8ee8', '<p>\n	3 x (5 + 4) - 7</p>\n', 'CORRECT'),
(526, 115, '9217745a-cb41-46ed-bf80-65a177a9e208', '<p>\n	3 x 5 + (4 - 7)</p>\n', 'OTHER'),
(527, 115, '3a83e1fd-bd76-4101-8556-b6eb6da5dc0c', '<p>\n	3 x (5 + 4 - 7)</p>\n', 'OTHER'),
(528, 116, '0d63b836-7bc1-41f4-8640-091401ec4587', '<p>\n	8<sup>o </sup>F</p>\n', 'OTHER'),
(529, 116, 'a252e136-af29-4367-8439-63d53d607fca', '<p>\n	13<sup>o</sup> F</p>\n', 'OTHER'),
(530, 116, '5c0da26d-75e3-4bcc-a26f-d20cbe57b57a', '<p>\n	18<sup>o</sup> F</p>\n', 'OTHER'),
(531, 116, '2c4bc2cc-db0f-4808-9ac9-cfc7e2723ffa', '<p>\n	23<sup>o</sup> F</p>\n', 'CORRECT'),
(532, 117, '5289cc1e-419d-49c1-b242-e4f086cf552f', '<p>\n	1,735</p>\n', 'OTHER'),
(533, 117, '5e0c375f-cd7e-4b8f-ab87-2c04dd7a0644', '<p>\n	1,835</p>\n', 'CORRECT'),
(534, 117, '5159eca7-d5ae-46aa-a0ea-536167baaff7', '<p>\n	1,935</p>\n', 'CARELESS'),
(535, 117, 'd8c1223b-aa69-4ebb-bb13-318b89b0a85b', '<p>\n	2,835</p>\n', 'OOB'),
(536, 118, '621a1d6e-52f6-4e72-b1d6-d2b314c22fde', '<p>\n	between $20 and $25</p>\n', 'OTHER'),
(537, 118, 'b5e53b55-0fe6-4c3a-8e67-ba08a981d518', '<p>\n	between $25 and $30</p>\n', 'OTHER'),
(538, 118, '30ce4eaa-1162-4d18-b5be-b54a3b073ccc', '<p>\n	between $30 and $35</p>\n', 'OTHER'),
(539, 118, '6871b11f-be66-40db-b203-662c4d898c1d', '<p>\n	between $35 and $40</p>\n', 'CORRECT'),
(540, 119, '65ee6c39-bff4-46c5-8edb-3c7f5a0ba229', '<p>\n	3,000</p>\n', 'CARELESS'),
(541, 119, '749528be-0048-4980-8bc4-0cdfece7fb60', '<p>\n	5,000</p>\n', 'OTHER'),
(542, 119, '7a70be06-ff47-4daf-8bd6-e8f205887dd0', '<p>\n	10,000</p>\n', 'OTHER'),
(543, 119, '55b272d8-c48a-42a8-aeac-3ad7930dac00', '<p>\n	15,000</p>\n', 'CORRECT'),
(544, 120, '3b5e5b53-e037-4229-ba94-71c6f985041a', '<p>\n	7.6</p>\n', 'OOB'),
(545, 120, 'e9fc2146-df90-4128-acf2-bf466a08305f', '<p>\n	7.9</p>\n', 'CORRECT'),
(546, 120, '6b0ed6db-88e8-4dcb-90d7-f6aae566785c', '<p>\n	8.0</p>\n', 'OTHER'),
(547, 120, '16f5ccdf-bda9-48fe-8e3d-8093f0c4e7a5', '<p>\n	8.3</p>\n', 'OTHER'),
(548, 121, 'ad1020b3-e39b-4848-bf7c-fc3ee2152cc9', '<p>\n	odd numbers</p>\n', 'OOB'),
(549, 121, '92c1609b-19ae-4d97-82d9-47f36bdc4809', '<p>\n	even numbers</p>\n', 'OOB'),
(550, 121, '39b0a3ad-d541-4fd1-8312-4f2d4b2d24fb', '<p>\n	prime numbers</p>\n', 'CORRECT'),
(551, 121, 'ec538663-01a5-4d48-a958-fda6c9e05e4c', '<p>\n	composite numbers</p>\n', 'OTHER'),
(552, 122, '627bbbd0-9253-4b4a-9281-927021752a47', '<p>\n	34</p>\n', 'OTHER'),
(553, 122, '7cff3928-3a11-4efc-8359-bed54c38a121', '<p>\n	44</p>\n', 'CORRECT'),
(554, 122, '0dda6c59-17d3-430d-915a-53b3eba96062', '<p>\n	54</p>\n', 'OTHER'),
(555, 122, '130ab1a6-7dea-4ed2-ab34-ab7972574fb9', '<p>\n	64</p>\n', 'OTHER'),
(556, 123, '714581be-db1e-44c3-bcb6-521dbe54e318', '<p>\n	10 A.M.</p>\n', 'OTHER'),
(557, 123, '6e3e1d7d-431b-4daa-a1da-187258169f46', '<p>\n	1 P.M.</p>\n', 'OTHER'),
(558, 123, '281acf33-73e1-42e5-a477-117d7c45e739', '<p>\n	5 P.M.</p>\n', 'OTHER'),
(559, 123, 'baaa2f25-984e-444f-9229-38e341e680fb', '<p>\n	8 P.M.</p>\n', 'CORRECT'),
(560, 124, 'f54e0d37-ba0e-48fe-a005-860e46c705d0', '<p>\n	13 inches</p>\n', 'OOB'),
(561, 124, '257df67b-952d-430b-a9b9-fa576582de8f', '<p>\n	23 inches</p>\n', 'CARELESS'),
(562, 124, 'd436fe8b-7a7a-402a-88d6-5ee85976f8bb', '<p>\n	26 inches</p>\n', 'CORRECT'),
(563, 124, '57943126-ebdb-4402-886c-cce2efa9acc6', '<p>\n	28 inches</p>\n', 'OTHER'),
(564, 125, '6a71c7b9-24bb-47c7-8323-f62b848bd7db', '<p>\n	<img align="middle" src="8301738141d913b75d7cafe03ea31f6d.png" /></p>\n', 'CORRECT'),
(565, 125, '5d5d1d2a-4360-402d-ab38-b3d151acc3cf', '<p>\n	<img align="middle" src="c3a264073e0da987448c0f9deecc8e7d.png" /></p>\n', 'OTHER'),
(566, 125, 'efd1a796-fc9f-4dd5-b312-03a157056706', '<p>\n	<img align="middle"  src="557fb4eb8563f6d78b1b0d5509c50336.png" /></p>\n', 'OTHER'),
(744, 171, 'eb29d8e4-1d11-477f-813d-e0d5d1b994ae', '<p>\n	RCQ2 A1</p>\n ', 'CORRECT'),
(567, 125, '6e03901b-3f48-4544-8d84-5662791d3e85', '<p>\n	<img align="middle"  src="5e6107069f25d5cb14ca6fa8cf5df9e5.png" /></p>\n', 'OTHER'),
(568, 126, 'cfe0c37a-06d2-440f-bf6a-61534a3868db', '<p>\n	(1,7)</p>\n', 'OTHER'),
(569, 126, '62dbd127-576c-4de3-bd80-f22436fb29b2', '<p>\n	(1,8)</p>\n', 'CORRECT'),
(570, 126, '62dbd127-576c-4de3-bd80-f22436fb29b2', '<p>\n	(8,1)</p>\n', 'CORRECT'),
(571, 126, 'f65aa08b-e71d-43e4-9a56-3fa2c5c3fbd8', '<p>\n	(8,2)</p>\n', 'OTHER'),
(572, 127, '01c6a03d-85a0-461c-b2eb-915c334ce4d0', '<p>\n	<img align="middle" src="800d83ab32097a938747651e5faa1644.png" /></p>\n', 'OTHER'),
(573, 127, '26cc11e8-90fc-4073-9b70-c84c0ea71b33', '<p>\n	<img align="middle" src="c72bd8cfc77c216fc2d37d7b1494c5b5.png" /></p>\n', 'OTHER'),
(574, 127, '1214df34-28ba-4db0-9990-d33b7a83a73a', '<p>\n	<img align="middle" src="583637b2e0dc9a842c91d95f3b3a1c96.png" /></p>\n', 'OTHER'),
(575, 127, 'e451cea0-fae9-42cb-ba67-01aeaddaa404', '<p>\n	<img align="middle" src="0f2f72105b6f0b79804f6ef0599058da.png" /></p>\n', 'OTHER'),
(576, 128, 'cb7aa7e0-f435-45e4-b89c-f717a5b0cb18', '<p>\n	<img alt="" src="6b64e3f1756ce85c83641331891aeb89.png" style="width: 22px; height: 46px;" /></p>\n', 'OOB'),
(577, 128, '8c78abd3-7ff9-4ddf-a429-2c2cd60552f5', '<p>\n	<img alt="" src="979b7fd5598879ac6a5709e1493f4bee.png" style="width: 22px; height: 46px;" /></p>\n', 'OOB'),
(578, 128, 'af7d59fb-66b7-4c76-8850-e230980583dd', '<p>\n	<img align="middle"  src="74070d5c4245410ba82058b40c668ff8.png" /></p>\n', 'OTHER'),
(742, 170, '95a9e107-5010-4ed1-b7e6-81af34423b72', '<p>\n	Enter Choice3</p>\n ', 'OTHER'),
(741, 170, '222e0c3c-aab5-4364-8d8b-d1d41b6884dd', '<p>\n	Enter Choice2</p>\n ', 'OTHER'),
(579, 128, '6a169b55-be06-4ef6-8bf3-a44bbbe9bd07', '<p>\n	<img align="middle"  src="509641938cd8fd90c8a20dbc5915e1d9.png" /></p>\n', 'CORRECT'),
(740, 170, '3c12123b-e37d-44c9-8ac4-d5dd3f344563', '<p>\n	Enter Choice1</p>\n ', 'OTHER'),
(580, 129, 'd4f00973-bdc3-430a-a6b7-589f67573f70', '<p>\n	Lake Nyasa, which has an area of 11,430 mi<sup>2</sup></p>\n', 'CORRECT'),
(581, 129, '7e6b0bb3-8358-4d85-a3e9-d6c7e1dc8f97', '<p>\n	Lake Tanganyika, which has an area of 12,700 mi<sup>2</sup></p>\n', 'OTHER'),
(582, 129, 'edd6a206-cda0-4714-b38a-03683aed30d8', '<p>\n	Lake Huron, which has an area of 23,000 mi<sup>2</sup></p>\n', 'OOB'),
(583, 129, '285de62e-0354-4305-9e33-90e53cbc3109', '<p>\n	Lake Victoria, which has an area of 26,828 mi<sup>2</sup></p>\n', 'OOB'),
(807, 186, 'da1a8b2e-16c3-4a26-a6a2-c58699cc9c58', '<p>\n	Enter Choice4</p>\n ', 'CORRECT'),
(805, 186, '435af73a-accf-491d-9835-fc2663e2da64', '<p>\n	Enter Choice2</p>\n ', 'OTHER'),
(806, 186, 'c4fdbca8-0b54-42c7-9d8e-079362658df1', '<p>\n	Enter Choice3</p>\n ', 'OTHER'),
(793, 183, '421c22b0-06a5-4b17-aa27-4c1962fdc08b', '<p>\n	Enter Choice2</p>\n ', 'OTHER'),
(794, 183, '6aa50f81-7aea-420a-aa23-5b2554695c52', '<p>\n	Enter Choice31</p>\n ', 'OTHER'),
(795, 183, '9ba467b8-3a9d-4ca3-a7ef-976674478833', '<p>\n	Enter Choice41</p>\n ', 'CORRECT'),
(796, 184, '474a1ae8-2314-4dd2-ab35-74fcb08c5ce6', '<p>\n	Enter Choice1AB</p>\n ', 'CORRECT'),
(797, 184, '97aab556-42e9-4d97-bc74-60abbdae6dc4', '<p>\n	Enter Choice2AB</p>\n ', 'CARELESS'),
(798, 184, '18132fa1-cd55-4a74-9fac-5c30ca129a49', '<p>\n	Enter Choice3AB</p>\n ', 'OTHER'),
(799, 184, 'a2562522-f6df-4c3f-9888-b95e62ac4448', '<p>\n	Enter Choice4AB</p>\n ', 'OTHER'),
(792, 183, '11020b04-f498-4af3-9046-488bb8becf7f', '<p>\n	Enter Choice11</p>\n ', 'OTHER'),
(791, 182, '4e1c7607-9f4c-471d-a455-b21c41a7e3dc', '<p>\n	Enter Choice4</p>\n ', 'OTHER'),
(790, 182, 'bfb5c240-2ef5-4efe-8f7a-14ec0e81e5a3', '<p>\n	Enter Choice3</p>\n ', 'OTHER'),
(789, 182, '75facb40-8465-4978-a53e-240a5d683da6', '<p>\n	Enter Choice2</p>\n ', 'OTHER'),
(788, 182, '1d40bd57-0502-4393-94dc-0d0a4d9a1c7c', '<p>\n	Enter Choice1</p>\n ', 'CORRECT'),
(787, 181, '76f909ef-6d29-4aaf-8fd0-6cd8309befd3', '<p>\n	RCQ1</p>\n<p>\n	', 'CARELESS'),
(786, 181, '457c7fd7-59c1-4960-9d42-c35728f46361', '<p>\n	RCQ1</p>\n<p>\n	', 'OOB'),
(785, 181, 'eb742dfe-cc50-4360-899f-b6abc75d878c', '<p>\n	RCQ1</p>\n<p>\n	', 'CARELESS'),
(784, 181, '13668f94-4025-4273-9fcc-c1c225f9b5aa', '<p>\n	RCQ1444</p>\n<p>\n	', 'CORRECT'),
(783, 180, '6bad1e84-8d7e-4fb0-9432-00353f8cdfa7', '<p>\n	RC C1 Choice4</p>\n ', 'CARELESS'),
(782, 180, '3b816183-4cc1-49b3-b6ea-c632d21458f7', '<p>\n	RC C1 Choice3</p>\n ', 'OOB'),
(781, 180, '86ebb384-462f-4ab6-b09c-d03c0619393d', '<p>\n	RC C1 Choice2</p>\n ', 'CARELESS'),
(780, 180, '49d88f4f-7150-4164-b405-348aeca09923', '<p>\n	RC C1</p>\n ', 'CORRECT'),
(779, 0, '0ae2a847-0cf1-4634-be0d-f9b2d028f858', '<p>\n	Rc Chouce 4</p>\n ', 'OTHER'),
(778, 0, 'db8d65f6-401d-442d-a4bc-6ea43fc9e313', '<p>\n	RC CHoice 3</p>\n ', 'OTHER'),
(776, 0, 'bfc59850-3a63-4276-814d-25d7d93bf2f2', '<p>\n	RC Choice1</p>\n ', 'CORRECT'),
(777, 0, '0d390e7e-7766-4ead-8d40-e6bf876b167c', '<p>\n	RC CHoice 2</p>\n ', 'OTHER'),
(804, 186, '24b93671-1088-4959-89de-d1ec631f649b', '<p>\n	Enter Choice1</p>\n ', 'OTHER'),
(803, 185, '366721bc-3262-48cb-9f0e-6c1f571e2a50', '<p>\n	Enter Choice4AAA</p>\n ', 'CARELESS'),
(802, 185, '63e94c5b-8d90-4b70-9283-ba7430eb1b92', '<p>\n	Enter Choice3AAA</p>\n ', 'OTHER'),
(801, 185, 'd198f21d-e313-4305-a30b-e29a40cf24c9', '<p>\n	Enter Choice2AAA</p>\n ', 'OTHER'),
(800, 185, 'cd15e7b0-baa9-4412-8533-8b779af26130', '<p>\n	Enter Choice1AAA</p>\n ', 'CORRECT');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('8e5071e745fba770428046cb27a37065', '0.0.0.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0 FirePHP/0.7.2', 1372142789, 'a:2:{s:9:"user_data";s:0:"";s:17:"flash:new:message";s:64:"<p class="status_msg">You have been successfully logged out.</p>";}');

-- --------------------------------------------------------

--
-- Table structure for table `family_profile`
--

CREATE TABLE IF NOT EXISTS `family_profile` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT COMMENT 'row counter',
  `familyId` char(36) NOT NULL COMMENT 'Family uuid shared by parents and kids - autogenerated by system; used to index into student_profile table',
  `parentFirstName` varchar(20) NOT NULL COMMENT 'Parent''s first name',
  `parentLastName` varchar(50) NOT NULL COMMENT 'Parent last name',
  `familyAddress1` varchar(120) NOT NULL COMMENT 'street address',
  `familyAddress2` varchar(255) NOT NULL COMMENT 'Line 2 for street address (optional)',
  `familyCity` varchar(20) NOT NULL COMMENT 'city',
  `familyState` varchar(20) NOT NULL COMMENT 'state',
  `familyZip` varchar(15) NOT NULL COMMENT 'zip code',
  `familyPhone` varchar(25) NOT NULL COMMENT 'phone number',
  `parentPrimary_uacc_id` int(11) NOT NULL COMMENT 'Primary parent''s user account id from user_accounts table',
  `parentAlt_uacc_id` int(11) NOT NULL COMMENT 'optional alternative parent user_account id from user_account table',
  PRIMARY KEY (`rowCounter`),
  UNIQUE KEY `familyId` (`familyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `family_profile`
--

INSERT INTO `family_profile` (`rowCounter`, `familyId`, `parentFirstName`, `parentLastName`, `familyAddress1`, `familyAddress2`, `familyCity`, `familyState`, `familyZip`, `familyPhone`, `parentPrimary_uacc_id`, `parentAlt_uacc_id`) VALUES
(1, '8ffff72b-1e5b-4ea3-b9b7-eb8f02e18806', 'Maya', 'Misneroni', '1330 Greenwood', 'Apartment#2', 'Palo Alto', 'CA', '94301', '3227976', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `generated_tests`
--

CREATE TABLE IF NOT EXISTS `generated_tests` (
  `rowCounter` int(16) NOT NULL AUTO_INCREMENT COMMENT 'just a dumb row counter',
  `testId` char(36) NOT NULL COMMENT 'testId of the negerated tests',
  `testType` enum('ISEE_LOW','ISEE_MED','ISEE_HIGH') NOT NULL COMMENT 'enumerated set of test types this question can belong to.  Singleton value.  Examples: ISEE_LOW, ISEE_HIGH, SSAT, SAT, etc',
  `testGenerationDateTime` datetime NOT NULL COMMENT 'date and time (UTC) when test was generated',
  `sectionId` char(36) NOT NULL COMMENT 'UUID of the section in the testId',
  `questionSequence` int(16) NOT NULL COMMENT 'sequence numbering of questions in each section',
  `questionId` int(16) NOT NULL COMMENT 'questionId''s of all the questions in this test',
  PRIMARY KEY (`rowCounter`),
  KEY `questionSequence` (`questionSequence`),
  KEY `testId` (`testId`),
  KEY `testType` (`testType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table with map of questions in a test' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `generated_tests_passages`
--

CREATE TABLE IF NOT EXISTS `generated_tests_passages` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT,
  `testId` char(36) NOT NULL,
  `passageId` int(11) NOT NULL,
  `passage` varchar(4000) NOT NULL COMMENT 'Body of the passage',
  `num_questions` int(11) NOT NULL COMMENT 'Number of questions associated with the passage',
  `q1` int(11) NOT NULL,
  `q2` int(11) NOT NULL,
  `q3` int(11) NOT NULL,
  `q4` int(11) NOT NULL,
  `q5` int(11) NOT NULL,
  PRIMARY KEY (`rowCounter`),
  KEY `testId` (`testId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Passages and questions associated with a generated test' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `passages`
--

CREATE TABLE IF NOT EXISTS `passages` (
  `passageId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Passage Id',
  `passage` varchar(4000) NOT NULL COMMENT 'Reading comprehension passage upon which a set of questions are based',
  PRIMARY KEY (`passageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Reading comprension passages' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `passages`
--

INSERT INTO `passages` (`passageId`, `passage`) VALUES
(1, '<p>\n	1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; His days already crowded with work,<br />\n	2 Frederick Douglass found time for another job.<br />\n	3 As a former slave himself, he made time to<br />\n	4 work on the Underground Railroad.<br />\n	5 The Underground Railroad was not a<br />\n	6 railroad with trains and tracks. But it did have<br />\n	7 passengers, conductors, stations, and<br />\n	8 stationmasters. Runaway slaves were the<br />\n	9 passengers, and the conductors were the people<br />\n	10 who led them North. The station was where<br />\n	11 they rested and hid&mdash;usually the homes of<br />\n	12 people who hated slavery. These were<br />\n	13 stationmasters.<br />\n	14&nbsp;&nbsp;&nbsp;&nbsp; Frederick Douglass&rsquo; home in Rochester,<br />\n	15 New York, was a station on the Underground<br />\n	16 Railroad. He never knew when to expect a<br />\n	17 group of slaves. Usually they came late at night<br />\n	18 with a knock on the door. Frederick and Anna,<br />\n	19 his wife, would look at each other and know&mdash;<br />\n	20 the Underground Railroad was running. Anna<br />\n	21 would ready the house and Frederick would go<br />\n	22 to the door. He wouldn&rsquo;t open it. First he would<br />\n	23 whisper, &ldquo;Who&rsquo;s there?&rdquo; &ldquo;A friend with<br />\n	24 friends,&rdquo; someone would answer. Then<br />\n	25 Frederick knew it was safe to let them inside.<br />\n	26&nbsp;&nbsp;&nbsp;&nbsp; Frederick Douglass&rsquo; whole family worked<br />\n	27 on the Railroad. His five children helped him<br />\n	28 hide the slaves and make them comfortable.<br />\n	29 &ldquo;Remember,&rdquo; Frederick said, &ldquo;they are guests<br />\n	30 in our house.&rdquo; They had to be quick guests.<br />\n	31 Traveling on the Underground Railroad was<br />\n	32 dangerous. Grown-ups talked in whispers and<br />\n	33 children learned to play in whispers, too.<br />\n	34&nbsp;&nbsp;&nbsp;&nbsp; In 1850, the Underground Railroad became<br />\n	35 more dangerous when a new law was passed.<br />\n	36 Called the Fugitive Slave Law, it said that<br />\n	37 runaway slaves must be returned to their<br />\n	38 masters. Anyone caught hiding slaves would be<br />\n	39 fined or thrown in jail.<br />\n	40&nbsp;&nbsp;&nbsp;&nbsp; Slaves were not safe anywhere in the<br />\n	41 United States. They had to escape to Canada.<br />\n	42 Frederick Douglass&rsquo; home in Rochester became<br />\n	43 an important station, since it was the last station<br />\n	44 on the line on Lake Ontario. Across the lake lay<br />\n	45 the safety of Canada.<br />\n	46&nbsp;&nbsp;&nbsp;&nbsp; Over the years, Frederick Douglass helped<br />\n	47 over 400 slaves escape. Each time he thought,<br />\n	48 &ldquo;There goes one less slave, one more free<br />\n	49 person.&rdquo;</p>\n'),
(2, '<p>\n	1&nbsp;&nbsp;&nbsp;&nbsp; When a building is torn down, a vacant lot<br />\n	2 is created. However, the lot will not remain<br />\n	3 &ldquo;vacant&rdquo; for long. Soon the first plants will<br />\n	4 appear.<br />\n	5&nbsp;&nbsp;&nbsp;&nbsp; On rare occasions, seeds may remain under<br />\n	6 buildings for decades, perhaps a hundred years<br />\n	7 or more. The building over them keeps them<br />\n	8 dry and preserved. Once the building goes,<br />\n	9 rainwater may dampen the seeds and cause<br />\n	10 them to sprout. When this happens, new plants<br />\n	11 will start growing in the vacant lot.<br />\n	12&nbsp;&nbsp;&nbsp;&nbsp; This sort of thing happened in London after<br />\n	13 the city was bombed during the Second World<br />\n	14 War. After many damaged buildings were torn<br />\n	15 down, beautiful wild flowers that had not been<br />\n	16 known to grow in London for hundreds of<br />\n	17 years started growing in the vacant lots.<br />\n	18&nbsp;&nbsp;&nbsp;&nbsp; Even if this does not happen with old seeds,<br />\n	19 plants will show up anyway. Some of the seed<br />\n	20 swill is carried in the wind to the newly formed<br />\n	21 vacant lot. Birds will leave undigested seeds on<br />\n	22 the ground in their droppings. Other seeds may<br />\n	23 drop off the clothing of people walking near or<br />\n	24 across the vacant lots. Eventually, seeds of<br />\n	25 plants and spores of mosses and ferns will find<br />\n	26 their way to the lot.<br />\n	27&nbsp;&nbsp;&nbsp;&nbsp; If the lot is left free to develop for many<br />\n	28 years and receives adequate sunlight and rain,<br />\n	29 its plant life will follow a predictable life cycle.<br />\n	30 Its first plant inhabitants will be weeds and<br />\n	31 wild flowers, such as dandelions and clover.<br />\n	32 Over the years, grasses will appear, followed<br />\n	33 by vines and quick-growing trees such as the<br />\n	34 white pine. In a few years, the lot will probably<br />\n	35 become home to birds, insects, and many small<br />\n	36 animals.<br />\n	37&nbsp;&nbsp;&nbsp;&nbsp; Vacant lots may appear to be ugly, harsh<br />\n	38 places. Yet, they teach us something. They<br />\n	39 prove that life, if given half a chance, will take<br />\n	40 over any place it can&mdash;even a vacant lot.</p>\n'),
(3, '<p>\n	1&nbsp;&nbsp;&nbsp;&nbsp; On a recent trip to the Oakland Museum to<br />\n	2 see a display of African American quilts,<br />\n	3 several students got lost. We boarded two<br />\n	4 different subway cars, and about six students<br />\n	5 who were in the car next to mine decided to<br />\n	6 take advantage of my not being there. They<br />\n	7 began walking from one car to the other, which<br />\n	8 they are not supposed to do. When we came to<br />\n	9 our stop, they didn&rsquo;t know it was time to get off<br />\n	10 since they were in a different car. As I was<br />\n	11 counting noses in the station, I saw six of them<br />\n	12 pressed up against the glass in the last car,<br />\n	13 looking worried and distraught as the train<br />\n	14 pulled out.<br />\n	15&nbsp;&nbsp;&nbsp;&nbsp; I went upstairs to speak with the<br />\n	16 stationmaster, who phoned ahead to check with<br />\n	17 security personnel. They reported that the<br />\n	18 students had not disembarked at the next<br />\n	19 station. So the stationmaster got on the paging<br />\n	20 system and announced, &ldquo;Will Ms. Logan&rsquo;s<br />\n	21 students please call 214. Will Ms. Logan&rsquo;s<br />\n	22 students please call 214.&rdquo; I returned to the train<br />\n	23 platform downstairs to see the rest of my class<br />\n	24 running around wildly looking for a phone.</p>\n'),
(4, '<p>\n	1&nbsp;&nbsp;&nbsp;&nbsp; One spring I celebrated the first ant parade<br />\n	2 that found its way into my kitchen by allowing<br />\n	3 it to do whatever it wanted to. A steady line of<br />\n	4 ants filed from a crack just below a windowsill<br />\n	5 to the corner of my sink, where I keep a small<br />\n	6 drainer of vegetable wastes for my compost<br />\n	7 heap. Another line was headed just as steadily<br />\n	8 in the other direction.<br />\n	9&nbsp;&nbsp;&nbsp;&nbsp; Because my drainer contained too many<br />\n	10 odds and ends for me to see exactly what it was<br />\n	11 the ants were after, I set up a feeding station to<br />\n	12 determine their food preferences. I turned a<br />\n	13 dinner plate upside down, and on its rounded,<br />\n	14 easily accessible surface, I dabbed a few items:<br />\n	15 a little peanut butter, some honey, some cottage<br />\n	16 cheese, and plain water. As the day went by, I<br />\n	17 added a piece of apple, some raw egg white,<br />\n	18 milk, and vinegar.<br />\n	19&nbsp;&nbsp;&nbsp;&nbsp; I soon learned that they were interested in<br />\n	20 everything except the vinegar, but their real<br />\n	21 favorite was the honey. There were always four<br />\n	22 or five ants crowded around the honey drop,<br />\n	23 while just one or two were exploring the other<br />\n	24 substances.<br />\n	25&nbsp;&nbsp;&nbsp;&nbsp; As much as I enjoyed watching the ants<br />\n	26 making their food choices, I concluded that<br />\n	27 such encouragement was not good for our<br />\n	28 relationship. So I cleared up my feeding station<br />\n	29 and began my annual effort to eliminate or<br />\n	30 protect the foods that invite ants to forage<br />\n	31 indoors.</p>\n'),
(7, '<p>\n	<strong>Read the story &quot;Why the Sky Is Far Away&quot; before answering Numbers 1 through 5 in the Answer Section.</strong><br />\n	&nbsp;<br />\n	Why the Sky is Far Away</p>\n<p>\n	<br />\n	&nbsp;&nbsp;&nbsp;&nbsp; Ramon looked at the food on his tray and made a face. &quot;Macaroni and cheese again,&quot; he said to his friend Brian. &quot;They never serve anything good for lunch.&quot;<br />\n	<br />\n	Brian gave his own lunch a critical look and frowned. &quot;You think that&rsquo;s bad,&quot; he said, &quot;I&rsquo;ve got peanut butter and jelly again. It&rsquo;s the third time this week!&quot;<br />\n	<br />\n	They pushed the food aside. &quot;We can get something at the burger place after school,&quot; Ramon said. They concentrated on studying for their English test instead of eating. English was next period, and Mr. Friedman had a reputation for giving difficult tests. When the bell rang, they dropped their uneaten lunches into the garbage. Mr. Friedman was standing nearby. &quot;Not hungry, guys?&quot; he asked. They shook their heads and hurried off to class.<br />\n	<br />\n	When the test was over, there were still ten minutes left in the period. Mr. Friedman stood at the front of the class.<br />\n	<br />\n	&quot;Before you leave today,&quot; he said, leaning against the desk, &quot;I&rsquo;d like to share an old African folktale with you. I think you&rsquo;ll find this one interesting. It&rsquo;s called &lsquo;Why the Sky Is Far Away&rsquo;&quot;:<br />\n	<br />\n	&nbsp;&nbsp; &nbsp;Long ago the sky was close to the Earth. Men and women did not have to plant their own food. Instead, when they were hungry, they just reached up and broke off a piece of the sky to eat. Sometimes the sky tasted like ripe bananas. Other times it tasted like roasted potatoes. The sky was always delicious.<br />\n	<br />\n	People spent their time making beautiful cloth. They painted beautiful pictures and sang songs at night. The grand king, Oba, had a wonderful palace. His servants made beautiful shapes out of pieces of sky.<br />\n	<br />\n	Many people in the kingdom did not use the gift of the sky wisely. When they took more than they could eat, the sky became angry. Some people threw the extra pieces into the garbage.<br />\n	<br />\n	Early one morning the angry sky turned dark. Black clouds hung over the land, and a great sky voice said to all the people, &quot;You are wasting my gift of food. Do not take more than you can eat. I don&rsquo;t want to see pieces of me in the garbage anymore or I will take my gift away.&quot;<br />\n	<br />\n	The king and the people trembled with fear. King Oba said, &quot;Let&rsquo;s be careful about how much food we take.&quot; For a long time, all the people were careful.<br />\n	<br />\n	But one man named Adami wasn&rsquo;t careful. At festival time, he took so many delicious pieces of sky that he couldn&rsquo;t eat them all. He knew he must not throw them away.<br />\n	<br />\n	He tried to give the pieces to his wife. &quot;Here, wife,&quot; Adami said. &quot;You eat the rest.&quot;<br />\n	<br />\n	&quot;I can&rsquo;t,&quot; Adami&rsquo;s wife said. &quot;I&rsquo;m too full.&quot;<br />\n	<br />\n	Adami asked all his children to help him eat the delicious pieces of sky, but the children couldn&rsquo;t eat one more bite. So Adami decided to try to hide the pieces at the bottom of the garbage pile.<br />\n	<br />\n	Suddenly, the sky became angry and the clouds turned black. &quot;You have wasted my gift of food again,&quot; yelled the sky. &quot;This time I will go away so you cannot waste me anymore.&quot;<br />\n	<br />\n	All of the people cried, &quot;What will we eat? We might starve!&quot;<br />\n	<br />\n	The sky said, &quot;You will have to learn how to plant crops in the ground and hunt in the forests. If you work hard, you may learn not to waste the gifts of nature.&quot;<br />\n	<br />\n	Everyone watched as the sky sailed away. From that time on, they worked hard to grow their food and cook their meals. They always tr');

-- --------------------------------------------------------

--
-- Table structure for table `passage_questions`
--

CREATE TABLE IF NOT EXISTS `passage_questions` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT COMMENT 'row counter',
  `passageId` int(11) NOT NULL COMMENT 'Passage upon which the questions are based',
  `questionId` int(11) NOT NULL COMMENT 'question ids from question_bank table that are based on this passage',
  PRIMARY KEY (`rowCounter`),
  UNIQUE KEY `questionId` (`questionId`),
  KEY `passageId` (`passageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='List of question ids that are associated with a particular passage' AUTO_INCREMENT=36 ;

--
-- Dumping data for table `passage_questions`
--

INSERT INTO `passage_questions` (`rowCounter`, `passageId`, `questionId`) VALUES
(1, 1, 63),
(2, 1, 64),
(3, 1, 65),
(4, 1, 66),
(5, 1, 67),
(6, 2, 52),
(7, 2, 53),
(8, 2, 54),
(9, 2, 60),
(10, 2, 61),
(11, 3, 55),
(12, 3, 56),
(13, 3, 57),
(14, 3, 58),
(15, 3, 59),
(26, 4, 68),
(27, 4, 69),
(28, 4, 70),
(29, 4, 71),
(30, 4, 72),
(31, 7, 180),
(32, 7, 181),
(33, 7, 182),
(34, 7, 183),
(35, 7, 184);

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE IF NOT EXISTS `question_bank` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique question id assigned to each question; primary key',
  `question` varchar(600) NOT NULL COMMENT 'text / image of the question',
  `sectionId` char(36) NOT NULL,
  `questionTopic` enum('SYNONYMS','SENTENCE_COMPLETION','ARITHMETIC','ALGEBRA','GEOMETRY','MATH_CONCEPT','MATH_APPLICATION','QUANTITATIVE_COMPARISON','SCIENCE_PASSAGES','SOCIAL_STUDY_PASSAGES','MATH_KNOWLEDGE_SKILLS','COMPUTATION_AND_COMPREHENSION','READING_COMP') NOT NULL COMMENT 'section specific topic this question belongs to.  Enumerated set',
  `correctAnswerId` char(36) NOT NULL COMMENT 'New system assigned UUID for the correct answer',
  PRIMARY KEY (`questionId`),
  KEY `sectionId` (`sectionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`questionId`, `question`, `sectionId`, `questionTopic`, `correctAnswerId`) VALUES
(1, '<p>REJECT:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '110bdc35-6679-49a2-8001-6d4fbb1ccee0'),
(2, '<p>NAG:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '08df7608-4345-4226-b325-2f921e4b32b3'),
(3, '<p>NUTRITIOUS:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '90664f42-29cf-4b5a-9d72-829b155bc546'),
(4, '<p>RENEW:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', 'eba1cb31-6d0e-4d1f-9fe6-3003bf28e976'),
(5, '<p>SUPERB:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '7e2c2d7b-5a2c-46b9-9eb8-ad16ec7a1dbe'),
(6, '<p>PARTICLE:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '920a4f1a-dbdf-4f83-9300-669f886bcc02'),
(7, '<p>NOVEL:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '2be774e9-a905-4223-919d-cbc7d262466c'),
(8, '<p>ELONGATE:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', 'af64397c-4903-490e-acc6-61861cd4b8ff'),
(9, '<p>SOLEMNLY:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', 'a81c6cab-7f40-4566-8d8d-439bf3f7d824'),
(10, '<p>UPROOT:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', 'bef514df-de05-473c-b7ca-31b20bfadf39'),
(11, '<p>SELDOM:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '26fb21dc-b625-4863-9495-ffd4dd238a11'),
(12, '<p>\n	ADHESIVE:</p>\n', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', ''),
(13, '<p>LIBERATE:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '146e8471-11a9-4258-96ff-07fb6940db70'),
(14, '<p>VIEWPOINT:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '11b72d9c-a18f-42ff-8b16-b35d504a1a01'),
(15, '<p>VIGILANCE:</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', '971df657-2aad-45d0-9bd3-1dda379dae40'),
(16, '<p>It is the natural beauty of Glacier County, with its waterfalls and snow-covered meadows, that ------- the thousands of tourists, hikers, and campers who visit each year.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '144aba48-61ad-4e6f-a2cd-623a1f52cc91'),
(17, '<p>Allergies are usually abnormal reactions to ------- substances such as dust, pollen, and animal dander</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', 'c2bae662-3bad-4599-84d1-aa2becf91887'),
(18, '<p>To reach maturity, a seagoing loggerhead turtle must survive many -------, such as attacks by gulls and hungry fish.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '8c2e2b79-e1bc-4ec4-87b1-78dcc6ee36cb'),
(19, '<p>Although Roman political life was centered in the cities, most Romans lived in the -------, growing crops, tending vines, or cultivating olive groves.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '666028db-06e4-4e3a-96c9-68c08ebc829c'),
(20, '<p>Anne Sullivan showed her ------- as Helen Keller’s teacher by working with her day and night to help her overcome her disabilities.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '9c3ec5b3-4dda-4d67-9517-a0d060147f52'),
(21, '<p>Like many other medical conditions, malnutrition is often easier to ------- before its occurrence than to treat after its onset.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '8d9fbe8e-847d-41d9-a6fc-af94674f8d75'),
(22, '<p>Hannah Moore, an English writer, was best known for her -------, works whose characters endured extremely sorrowful circumstances.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', 'fca8a005-1c77-478e-aaad-aa30e1db5b88'),
(23, '<p>The many types of fish and mammals displayed in the exhibit at the aquarium demonstrate the remarkable ------- of marine life.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '95285d52-f401-4119-9e1c-c04b5cb1d39f'),
(24, '<p>Although there were other contributing factors, the ------- cause of industrial growth was the flood of new inventions in eighteenth-century England.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '60532c5a-d1be-4f16-8289-14f957466598'),
(25, '<p>Although once ------- in Africa, cheetah populations have been greatly reduced due to hunting, loss of habitat, and decline of the cheetah’s prey.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '5bac81c1-703f-4450-9252-e10ead13c370'),
(26, '<p>Most artists begin training early in life, but Anna Mary “Grandma” Moses -------.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', 'db74957f-c483-4b65-9993-41fe05b861bf'),
(27, '<p>Since the students looked puzzled, their -------.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', 'cac81304-bfc8-4b97-b9fc-cfc6c9360dae'),
(28, '<p>The movie provided no moral instruction; rather, it invited us to -------.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '9b7f5b75-3986-4838-a1d0-7a3646dedc2f'),
(29, '<p>Compared to his early paintings, which were usually of lighthearted subjects, the later art of Winslow Homer -------.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', 'babd3741-e152-47fb-ab65-1b387580b175'),
(30, '<p>Although Frederic Chopin was personally on good terms with most musicians of his day, he -------.</p>', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', '01b033c5-f630-40e3-922f-f474595aba61'),
(52, '<p>\n	<strong>Which best characterizes plant life as it is described in the passage?</strong></p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '268f6fa6-1180-49de-94ad-d44a1f71cd59'),
(53, '<p>\n	<strong>In the fifth paragraph (lines 27–36), the author implies that the return of life to a vacant lot would be held back if</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '7da95954-6d38-41c1-8228-d3c579b0699d'),
(54, '<p>\n	<strong>The function of the last paragraph(lines 37– 40) is to</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '9ae4b594-0d04-465f-9ea0-dc10b1aa8461'),
(55, '<p>\n	<strong>The passage is primarily concerned with describing </strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '41d4a0bf-3bfb-45a9-9477-1d534a141dd4'),
(56, '<p> <strong>In line 18, “disembarked” most nearly means  </strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '8ec54cb2-eeae-43f6-afb2-3d0f59e9a5e3'),
(57, '<p> <strong>Which can be inferred from the last sentence (lines 22–24)? </strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'a9844633-c145-44d8-847d-273f5a1e878b'),
(58, '<p> <strong>The passage supplies information to answer which question? </strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'adec4018-016d-455b-9e58-b599d0f9a88a'),
(59, '<p>\n	<strong>According to the author, a group of students did not get off the subway at the appropriate station because </strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'e42dff52-dba4-49a6-8f9f-213d2c05e917'),
(60, '<p>\n	<strong>Which best expresses the main idea of the passage?</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '9b1b0be3-6623-4cae-ae48-c9233a200c3c'),
(61, '<p>\n	<strong>Which best characterizes plant life as it is described in the passage?</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '4ff9f2a9-957a-4942-b81b-898f5dcb353a'),
(63, '<p>\n	<strong>The primary purpose of the passage is to</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '7be650bc-ad9c-4e90-851c-89c08e57f602'),
(64, '<p>\n	<strong>The passage states that the slaves filled which role on the Underground Railroad?</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '5b25e1ea-cd4e-4f58-9327-8a376b7ab58c'),
(65, '<p>\n	<strong>In line 36, &ldquo;Fugitive&rdquo; most nearly means</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '44ee56a1-9f56-48c3-a346-b50658bbdd5a'),
(66, '<p>\n	<strong>According to the passage, how did Frederick Douglass&rsquo; job change in 1850?</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '5c7484d0-042a-471a-8a9f-90b3b0215239'),
(67, '<p>\n	<strong>The passage provides information to answer which question?</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'c7e879da-fa34-4da3-8acc-d33fd6fd7e8f'),
(68, '<p>\n	<strong>The main purpose of the passage is to describe how</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '2abe2f4f-8e50-4cb1-b205-4a6e3906ff16'),
(69, '<p>\n	<strong>The author&rsquo;s attitude toward ants is best described as one of</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'f76429fb-a8de-4c96-a6e1-06903ff322a6'),
(70, '<p>\n	<strong>By saying that such encouragement was not &ldquo;good for our relationship&rdquo; (lines 27&ndash;28), the author is suggesting that the ants could become</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '6110defd-9a09-47c7-8f7f-3b97ba4fcb11'),
(71, '<p>\n	<strong>In line 30, &ldquo;forage&rdquo; most nearly means to</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '156f417d-352a-446d-b6b0-f0733d62790f'),
(72, '<p>\n	<strong>The author turned the dinner plate upside down (lines 12 &ndash; 13) in order to</strong></p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'a23db35c-dbb1-4ba0-aa24-462bb6c6f6ab'),
(73, '<p>\n	This is a read comprehension question</p>\n', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'e177ed1b-808f-47fa-a5d3-647da1180096'),
(74, '<p>\n	The largest triangle shown below is divided into small triangles.</p>\n<p>\n	<img alt="" height="130" src="triangle-1.jpg</br>" width="139" /></p>\n<p>\n	What fraction of the largest triangle is shaded?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '47952a6a-2b05-49d9-94b5-f5c819dc3114'),
(75, '<p>\n	Which story best fits the equation 7 x 5 = 35?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'e444668d-42a8-47ca-bc37-da2dbe193c5c'),
(76, '<p>\n	<strong>Alice wrote down a whole number greater than 6 and less than 10. When Jim tried to guess the number, Alice told him it was greater than 8 and less than 12. What is Alice&rsquo;s number?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '71ceb411-64a0-43a8-be43-762fb82202dd'),
(77, '<p>\n	<strong>The perimeter of the triangle is 28 centimeters. The lengths of two of the sides are shown.</strong></p>\n<p>\n	<img alt="" src="triangle-2.jpg</br>" style="width: 200px; height: 90px;" /></p>\n<p>\n	What is the length of the third side?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'ec5d24f6-d70e-4d43-9328-77ae131974c3'),
(78, '<p>\n	<strong>The volume of the small, shaded cube is 1 unit<sup>3</sup>.</strong></p>\n<p>\n	<img alt="" src="cube-1.png" style="width: 180px; height: 130px;" /></p>\n<p>\n	What is the volume of the larger cube?</p>\n ', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', '9e022cd8-3ed1-4cec-9c8b-3c540c1c0def'),
(79, '<p>\n	<strong>The ingredients in the recipe were evenly mixed and equally divided into 5 bags.</strong></p>\n<p>\n	<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RECIPE<br />\n	10 cups of crisp corn cereal<br />\n	7 cups of pretzel sticks<br />\n	2 cups of raisins<br />\n	3 cups of chocolate chips<br />\n	1 cup of sunflower seeds</strong></p>\n<p>\n	<strong>Approximately how many cups of the mixture were placed in each bag?</strong></p>\n ', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'bee9e1b7-c853-4a13-bfff-0066cd480661'),
(80, '<p>\n	<strong>Nisha and Alex were riding their bikes at the same speed on a bike path. It took Nisha 20 minutes to ride 4 miles. How long did it take Alex to ride 12 miles?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'db1880e6-431b-496a-b951-dd4ee1d1676f'),
(81, '<p>\n	<strong>Which is the largest fraction?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '44107bde-0a4a-4f79-b71a-a370d856bf62'),
(82, '<p>\n	<strong>If x can be divided by both 3 and 5 without leaving a remainder, then x can also be divided by which number without leaving a remainder?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'a1f22d4f-5b7c-42c4-a89a-789403908a2d'),
(83, '<p>\n	Use the Venn diagram to answer the question.</p>\n<p>\n	<img alt="" src="Venn1.jpg" style="width: 200px; height: 139px;" /></p>\n<p>\n	What shapes could be found in the shaded part of the Venn diagram?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'a8749a5b-352d-4805-a46e-92f376c28d18'),
(84, '<p>\n	A class put three cans full of water in the sun. Each can was covered and had a thermometer in it to measure the temperature of the water in degrees Fahrenheit. One can was painted black, one can was painted white, and the third can was painted silver. The class collected the data shown below.</p>\n<p style="text-align: center;">\n	<img alt="" src="table-temperature.jpg</br>" style="height: 150px; width: 413px;" /></p>\n<p>\n	According to the pattern from these data, what would be the predicted temperature of the water in the black can at 70 minutes?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '8217d3e7-89fc-4a44-b49e-67ca84ee4fe4'),
(85, '<p>\n	<strong>Use the table to determine the rule.</strong></p>\n<p>\n	<img alt="" src="table-IO.jpg</br>" style="width: 180px; height: 119px;" /></p>\n<p>\n	What is the rule for the function?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', 'b459138a-b231-4fac-905e-b75d6be6cd45'),
(86, '<p>\n	<strong>The perimeter of a square is 8s. What is the length of one side?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'a441a519-af6c-48c6-bbfe-3b76ea58240f'),
(87, '<p>\n	<strong>Which is a value of x in the math equation 15 = 3x + 3</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', 'dcd28deb-e757-4cc4-82ca-2883c532f455'),
(88, '<p>\n	<strong>Use the figure below to answer the question.</strong></p>\n<p>\n	<img alt="" src="triangle-3.jpg</br>" style="width: 180px; height: 167px;" /></p>\n<p>\n	If two more rows were added to the figure, how many small triangles would the sixth row have, assuming the same pattern continues?</p>\n', '9189bb68-1491-11e2-87f7-9b085696ecdc', 'MATH_CONCEPT', 'b1fc412f-cc05-41b0-b2e3-daeedf6b4eb2'),
(89, '<p>\n	<strong>Use the pattern to help answer the question.</strong></p>\n<p>\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 + 3 = 2<sup>2</sup></p>\n<p>\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 + 3 + 5 = 3<sup>2</sup></p>\n<p>\n	1 + 3 + 5 + 7 = 4<sup>2</sup></p>\n<p>\n	<strong>What is the solution to</strong> 1 + 3 + 5 + 7 + 9 + 11 + 13 + 15?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'f02ca55b-2a83-4256-bc9b-0014dba3f782'),
(90, '<p>\n	<strong>A survey of 40 students&rsquo; favorite ice cream flavors is displayed in the circle graph shown.</strong></p>\n<p>\n	<img alt="" src="pie-chart-1.png" style="width: 180px; height: 156px;" /></p>\n<p>\n	About what fraction of the students chose strawberry as their favorite flavor?</p>\n ', '9189bb68-1491-11e2-87f7-9b085696ecdc', 'MATH_APPLICATION', ''),
(91, '<p>\n	<span style="font-size:12px;"><strong>A cat had a litter of 4 kittens. Two of the kittens weighed 2 1/2 ounces each, 1 kitten weighed 3 ounces, and 1 kitten weighed 4 ounces. What is the mean weight of the kittens from the litter?</strong></span></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '8b57ade2-1436-4f27-be1b-2157ffbe623e'),
(92, '<p>\n	<strong>Use the number line to answer the question.</strong></p>\n<p>\n	<img alt="" src="number-line-1.png</br>" style="width: 180px; height: 97px;" /></p>\n<p>\n	Which three numbers are the vertical arrows pointing to on the number line?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'd708d2ac-fa97-4f25-9b90-344853480c1f'),
(93, '<p>\n	The length of RS is x and the length of RT is y.</p>\n<p>\n	<img alt="" src="number-line-2.png</br>" style="width: 180px; height: 34px;" /></p>\n<p>\n	What is the length of ST?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', 'efea54c8-e870-4866-875d-1f48127ab0f7'),
(94, '<p>\n	<strong>In a warehouse, there are 687 boxes with 36 candles in each box. Which expression gives the best estimate of the total number of candles in the warehouse?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', '26617af6-a819-4955-93eb-d530bea481ec'),
(95, '<p>\n	<strong>The volume of the small, shaded cube is 1 unit<sup>3</sup>.</strong></p>\n<p>\n	<img alt="" src="cube-1.png</br>" style="width: 180px; height: 130px;" /></p>\n<p>\n	What is the volume of the larger cube?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', 'f0b35d14-08f4-40ca-afd6-1d5fecfe1ba8'),
(96, '<p>\n	<strong>Jar 1 and Jar 2 would each hold 1 cup of liquid when filled to the top. The jars shown are not completely filled to the top.</strong></p>\n<p>\n	<img alt="" src="jars-1.png</br>" style="width: 180px; height: 75px;" /></p>\n<p>\n	If the liquids in the two jars are combined, approximately how much liquid will there be altogether?</p>\n', '9189bb68-1491-11e2-87f7-9b085696ecdc', 'MATH_CONCEPT', 'b02146e6-b3c5-4ef8-9290-9349412118cc'),
(97, '<p>\n	<strong>The figure shown may be folded along one or more of the dotted lines.</strong></p>\n<p>\n	<img alt="" src="axes-1.png</br>" style="width: 250px; height: 204px;" /></p>\n<p>\n	Which line or pair of lines, when folded, will allow the semicircles to exactly match the original figure?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '16b6606a-7651-46b6-8796-e378e5efe05d'),
(98, '<p>\n	<strong>The ingredients in the recipe were evenly mixed and equally divided into 5 bags.</strong></p>\n<p>\n	<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; RECIPE<br />\n	10 cups of crisp corn cereal<br />\n	7 cups of pretzel sticks<br />\n	2 cups of raisins<br />\n	3 cups of chocolate chips<br />\n	1 cup of sunflower seeds</strong></p>\n<p>\n	<strong>Approximately how many cups of the mixture were placed in each bag?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '1db3f2d7-58e6-4f85-ada0-60e59070deaf'),
(99, '<p>\n	The scale on Tanji&rsquo;s map shows that 1.2 inches represents 10 miles. How many inches would it take to represent 25 miles?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '35162331-a0a8-4265-8d51-a86c196d912e'),
(100, '<p>\n	<strong>Ms. Hammond put the names of all her students in a hat. The probability that she will pull out a boy&rsquo;s name at random is 3 out of 7. There are 12 girls in the class. How many boys are in Ms. Hammond&rsquo;s class?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '820fb342-c8c0-4090-971b-2583d7985012'),
(101, '<p>\n	<strong>Use the diagram of the cube to answer the question.</strong></p>\n<p>\n	<img alt="" src="cube-2.png</br>" style="width: 200px; height: 165px;" /></p>\n<p>\n	How many small cubes are being used to build the large cube?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '6a0ac804-5c0d-411d-863e-23a08ff70f3e'),
(102, '<p>\n	<strong>Four students recorded the number of minutes spent reading at home for one night and recorded their data in the graph shown.</strong></p>\n<p>\n	<img alt="" src="bar-graph-1.png</br>" style="width: 200px; height: 216px;" /></p>\n<p>\n	<strong>Based on this graph, which conclusion is true about the number of minutes spent reading?</strong></p>\n', '9189bb68-1491-11e2-87f7-9b085696ecdc', 'MATH_CONCEPT', 'e601af7b-8605-49b6-8526-0a401fe89a59'),
(103, '<p>\n	Which equation can be read as &ldquo;2 more than 6 times a number is equal to 10 less than the number&rdquo;? Let n represent the unknown number.</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', '87dadd74-29b0-4c47-9e2a-f17a6ec03f7a'),
(104, '<p>\n	<strong>Use the figure shown to answer the question.</strong></p>\n<p>\n	<img alt="" src="polygon-1.png</br>" style="width: 200px; height: 183px;" /></p>\n<p>\n	How many triangular regions can be made in the figure by only drawing line segments from vertex P to the other vertices?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'ded1555d-84dc-4b6c-a9d2-2d263f8e581c'),
(105, '<p>\n	Kara has a box of chocolates with different cream fillings: caramel, vanilla, cinnamon, orange, and cocoa. The probability of<br />\n	choosing a chocolate filled with caramel is 4 out of 9. Which combination of chocolates is possible?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'fffa8e4e-6323-49b5-afd5-ab894e710852'),
(106, '<p>\n	<strong>Josh did the problem shown with his calculator.</strong></p>\n<p>\n	<img align="middle" height="34" src="e795b0e4a5f6cc5ba1604fe4cbbf1c29.png</br>" width="71" /></p>\n<p>\n	<strong>What is a reasonable estimation for his answer?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '5db6bf7e-d8a9-4c88-a308-043b67f508a2'),
(107, '<p>\n	<strong>What is the value of n in the expression</strong>:</p>\n<p>\n	<img align="middle"  src="e106f3447ced0bc6245a04f04e908843.png</br>" /></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'f42dac17-48e4-408e-b82c-85fb30c446c7'),
(108, '<p>\n	<strong>Use the number line shown to answer the question.</strong></p>\n<p>\n	<img alt="" src="number-line-3.png</br>" style="width: 200px; height: 41px;" /></p>\n<p>\n	<strong>P is the average of Q and another number. What is the other number</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '831d118d-b8af-4119-b5be-f72341167af3'),
(109, '<p>\n	<strong><span style="font-size: 12.000000pt; font-family: ''TimesNewRomanPSMT''">Use the Time Zone map to answer the question. </span></strong></p>\n<p>\n	<img alt="" src="timezone_map.png" style="width: 878px; height: 605px;" /></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '24e31c68-f4af-42a5-872a-eb58a46507ae'),
(110, '<p>\n	<span style="font-size:12px;"><strong>Use the triangle to answer the question.</strong></span></p>\n<p>\n	<img alt="" src="right-triangle-1.png" style="width: 242px; height: 239px;" /></p>\n<p>\n	<span style="font-size:12px;"><strong>What is the perimeter of the triangle?</strong></span></p>\n<p>\n	<span style="font-size:12px;"><em>(P=s+s+s)</em></span></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'bbba315b-784a-4691-b0aa-ad166d3d6c2c'),
(111, '<p>\n	<span style="font-size:12px;"><strong>A total of 28 students were asked which one of three snacks&mdash;ice cream, popsicles, or frozen yogurt&mdash;they preferred. If 17 students said they preferred ice cream, and 4 students said they preferred popsicles, how many students said they preferred frozen yogurt?</strong></span></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '94b0dd4d-1ff9-47e0-ac07-0dd49a4c6e15'),
(112, '<p>\n	What is the name of a rectangle with sides of equal length?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '75eb82e8-a72a-4d1f-8f10-0025fa1cde24'),
(113, '<p>\n	What is the standard form for two hundred three thousand forty-nine?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'b6b2a2d8-915e-4709-bdc1-5e9ae60c4ae9'),
(114, '<p>\n	<strong>What is the value of the expression 308 + 197?</strong></p>\n<p>\n	&nbsp;</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '1f159ec2-98e0-474d-872a-f212ad48f16d'),
(115, '<p>\n	<strong>Which expression is equal to 20?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '530618cf-91d9-476d-b4ab-10cc556f8ee8'),
(116, '<p>\n	A class put three cans full of water in the sun. Each can was covered and had a thermometer in it to measure the temperature of the water in degrees Fahrenheit. One can was painted black, one can was painted white, and one can was painted silver. The table shows the data collected.</p>\n<p>\n	<img alt="" src="table-temperature-2.png" style="width: 678px; height: 249px;" /></p>\n<p>\n	<strong>At 50 minutes, how much warmer was the water in the black can than the water in the white can?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '2c4bc2cc-db0f-4808-9ac9-cfc7e2723ffa'),
(117, '<p>\n	What is the value of the expression 2,000 &ndash; 165?</p>\n<p>\n	&nbsp;</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '5e0c375f-cd7e-4b8f-ab87-2c04dd7a0644'),
(118, '<p>\n	Chris buys five items costing $3.49, $11.99, $0.50, $2.99, and $16.99. What is the estimated total cost of Chris&rsquo; items?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '6871b11f-be66-40db-b203-662c4d898c1d'),
(119, '<p>\n	The graph shows the population of four towns.</p>\n<p>\n	<img alt="" src="population-table.png" style="width: 550px; height: 455px;" /></p>\n<p>\n	How many more people live in Southville than live in Eastville?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '55b272d8-c48a-42a8-aeac-3ad7930dac00'),
(120, '<p>\n	Use the table to answer the question.</p>\n<p>\n	<img alt="" src="hope-table.png" style="width: 735px; height: 145px;" /></p>\n<p>\n	&nbsp;</p>\n<p>\n	What is the mode of this set of data?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'e9fc2146-df90-4128-acf2-bf466a08305f'),
(121, '<p>\n	Use the set of numbers shown to answer the question.</p>\n<p>\n	<br />\n	{2, 3, 5, 7, 11, &hellip;}</p>\n<p>\n	<br />\n	Which describes this set of numbers?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '39b0a3ad-d541-4fd1-8312-4f2d4b2d24fb'),
(122, '<p>\n	<strong>Use the number sequence to answer the question.</strong></p>\n<p>\n	<br />\n	<strong>2, 4, 8, 14, 22, 32, ___</strong></p>\n<p>\n	<br />\n	<strong>What is the next number in the sequence?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '7cff3928-3a11-4efc-8359-bed54c38a121'),
(123, '<p>\n	<strong>Use the Time Zone map to answer the question.</strong></p>\n<p>\n	<img alt="" src="timezone_map.png" style="width: 878px; height: 605px;" /></p>\n<p>\n	<strong>An airplane leaves Seattle at 1:00 P.M. and arrives 4 hours later in Detroit. What time is it in Detroit?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'baaa2f25-984e-444f-9229-38e341e680fb'),
(124, '<p>\n	<strong>What is the perimeter of a rectangle that has a length of 8 inches and a width of 5 inches? (P = 2l + 2w)</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', 'd436fe8b-7a7a-402a-88d6-5ee85976f8bb'),
(125, '<p>\n	Terry had <img align="middle" src="e3c5059382ffa151facecfb88a86cb8d.png" /> feet of wire. He used <img align="middle"  src="1553399ee1e5664a234e0d64796425b4.png" /> feet of the wire to make a lamp. How many feed does he have left?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '6a71c7b9-24bb-47c7-8323-f62b848bd7db'),
(126, '<p>\n	<strong>Use the coordinate grid to answer the question.</strong></p>\n<p>\n	<img alt="" src="grid-1.png" style="width: 415px; height: 276px;" /></p>\n<p>\n	<strong>What are the coordinates of point P in the figure?</strong></p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '62dbd127-576c-4de3-bd80-f22436fb29b2'),
(127, '<p>\n	What is the sum of 2.9 + 1.7?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '92ac9f2f-32eb-45b0-af8f-eb1768be7240'),
(128, '<p>\n	Which fraction is between <img align="middle" class="Wirisformula" data-mathml="«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfrac»«mn»1«/mn»«mn»2«/mn»«/mfrac»«/math»" src="showimage.php?formula=41891f5e8ace60c819a1c76af3792a55.png" /> and <img align="middle" class="Wirisformula" data-mathml="«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfrac»«mn»9«/mn»«mn»10«/mn»«/mfrac»«/math»" src="showimage.php?formula=18481a8dba065b6ce5603f0b9bbfad49.png" /> ?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '6a169b55-be06-4ef6-8bf3-a44bbbe9bd07'),
(129, '<p>\n	Lake Superior has an area of about 31,700 mi<sup>2</sup>. Which lake has an area closest to <img align="middle" src="979b7fd5598879ac6a5709e1493f4bee.png" style="width: 22px; height: 46px;" /> that of Lake Superior?</p>\n', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', 'd4f00973-bdc3-430a-a6b7-589f67573f70'),
(180, '<p>\n	RC Q</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '6bad1e84-8d7e-4fb0-9432-00353f8cdfa7'),
(181, '<p>\n	RCQ1</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '13668f94-4025-4273-9fcc-c1c225f9b5aa'),
(182, '<p>\n	Enter Question</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'b733ce45-3281-4e4b-a360-aa4e356749b6'),
(183, '<p>\n	Enter Question1</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '75297eb7-cb7c-4ff0-a650-fbb8fe201a58'),
(184, '<p>\n	Enter Question11</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '474a1ae8-2314-4dd2-ab35-74fcb08c5ce6'),
(185, '<p>\n	RC Q</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', 'cd15e7b0-baa9-4412-8533-8b779af26130'),
(186, '<p>\n	Enter Question</p>\n ', '599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '2d724034-2e53-4aea-84cf-555e97b36266');

-- --------------------------------------------------------

--
-- Table structure for table `student_profile`
--

CREATE TABLE IF NOT EXISTS `student_profile` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT COMMENT 'row counter ',
  `uacc_id` int(11) NOT NULL COMMENT 'user id from user_accounts table',
  `familyId` char(36) NOT NULL,
  `studentFirstName` varchar(20) NOT NULL COMMENT 'Student;s first name',
  `studentLastName` varchar(50) NOT NULL COMMENT 'Student''s last name',
  `grade` smallint(6) NOT NULL,
  `testType` varchar(50) NOT NULL,
  PRIMARY KEY (`rowCounter`),
  UNIQUE KEY `userId` (`uacc_id`),
  KEY `familyId` (`familyId`),
  KEY `studentLastName` (`studentLastName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `student_profile`
--

INSERT INTO `student_profile` (`rowCounter`, `uacc_id`, `familyId`, `studentFirstName`, `studentLastName`, `grade`, `testType`) VALUES
(1, 2, '8ffff72b-1e5b-4ea3-b9b7-eb8f02e18806', 'Priya', 'Misner', 10, 'ISEE_LOW'),
(2, 3, '8ffff72b-1e5b-4ea3-b9b7-eb8f02e18806', 'Kiran', 'Misner', 8, 'ISEE_MED'),
(3, 4, '8ffff72b-1e5b-4ea3-b9b7-eb8f02e18806', 'Penny', 'Misner', 9, 'ISEE_HIGH');

-- --------------------------------------------------------

--
-- Table structure for table `submitted_answers`
--

CREATE TABLE IF NOT EXISTS `submitted_answers` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Non duplicate running counr',
  `internalAccountId` int(16) NOT NULL COMMENT 'internal ID for each student',
  `testId` char(36) NOT NULL COMMENT 'unique ID assigned to each test',
  `questionId` int(16) NOT NULL COMMENT 'Get from question_bank',
  `answerId` char(36) NOT NULL COMMENT 'answerId given by the student',
  `isCorrect` tinyint(1) NOT NULL COMMENT 'YES|NO',
  PRIMARY KEY (`rowCounter`),
  KEY `internalAccountId1` (`internalAccountId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tests_taken`
--

CREATE TABLE IF NOT EXISTS `tests_taken` (
  `rowCounter` int(11) NOT NULL AUTO_INCREMENT,
  `internalAccountId` int(16) NOT NULL,
  `testId` char(36) NOT NULL,
  `timedTest` tinyint(1) NOT NULL COMMENT 'Flag to indicate if this was a timed test or not',
  `startTimeDate` datetime NOT NULL COMMENT 'Time when this student started the test',
  `finishTimeDate` datetime NOT NULL COMMENT 'Time when they finished the test',
  `sectionId` char(36) NOT NULL,
  `sectionComplete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: section incomplete or not attempted; 1: section submitted or timer expired',
  `timeRemaining` int(11) NOT NULL COMMENT 'time in seconds remaining for section - only referenced in timed test mode',
  PRIMARY KEY (`rowCounter`),
  KEY `internalAccountId` (`internalAccountId`,`testId`,`sectionId`,`sectionComplete`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Table records all tests attempted by a student & state' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_section_metadata`
--

CREATE TABLE IF NOT EXISTS `test_section_metadata` (
  `testType` enum('ISEE_LOW','ISEE_MED','ISEE_HIGH') NOT NULL COMMENT 'enumerated set of test types this question can belong to.  Singleton value.  Examples: ISEE_LOW, ISEE_HIGH, SSAT, SAT, etc',
  `sectionName` enum('READING_COMP','MATH_ACH','QUANT_REASON','VERB_REASON','ESSAY') NOT NULL COMMENT 'full name of the section in the test (Verbal Reasoning, Quantitative Reasoning, Reading Comprehension, Reading Comprehension, Math Achievement, Essay)',
  `sectionId` char(36) NOT NULL,
  `sectionDuration` int(32) NOT NULL COMMENT 'permitted time for the section (in minutes)',
  `sectionInstructions` varchar(500) NOT NULL COMMENT 'directions for the entire section',
  `sectionNumChoices` int(32) NOT NULL DEFAULT '4' COMMENT 'number of potential answers to display',
  `correctAnswerScore` int(32) NOT NULL DEFAULT '1' COMMENT 'score assigned for correct answer',
  `incorrectAnswerScore` int(32) NOT NULL DEFAULT '0' COMMENT 'penalty for incorrect answer',
  `sectionNumQuestions` int(32) NOT NULL COMMENT 'number of total questions in this section',
  `sectionCustom` int(16) NOT NULL COMMENT 'Custom info that is specific to just this section. For example, it contains Number of passages in the reading comprehension section',
  PRIMARY KEY (`sectionName`),
  KEY `sectionId` (`sectionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_section_metadata`
--

INSERT INTO `test_section_metadata` (`testType`, `sectionName`, `sectionId`, `sectionDuration`, `sectionInstructions`, `sectionNumChoices`, `correctAnswerScore`, `incorrectAnswerScore`, `sectionNumQuestions`, `sectionCustom`) VALUES
('ISEE_LOW', 'READING_COMP', '599efc34-301d-11e2-a434-5958ac5abb9c', 20, 'This section contains four short reading passages. Each passage is followed by five questions based on its content. Answer the questions following each passage on the basis of what is stated or implied in that passage.', 4, 1, 0, 20, 4),
('ISEE_LOW', 'MATH_ACH', 'e1dd123e-3c48-11e2-8eff-86b90e19545a', 25, 'Each question is followed by four suggested answers. Read each question and then decide which one of the four suggested answers is best.', 4, 1, 0, 30, 0),
('ISEE_LOW', 'QUANT_REASON', '9189bb68-1491-11e2-87f7-9b085696ecdc', 5, 'Each question is followed by four suggested answers. Read each question and then decide which one of the four suggested answers is best. Find the row of spaces on your answer document that has the same number as the question. In this row, mark the space having the same letter as the answer you have chosen.', 4, 1, 0, 4, 0),
('ISEE_LOW', 'VERB_REASON', '9b07ad26-1491-11e2-87f7-9b085696ecdc', 18, 'This section is divided into two parts that contain two different types of questions. As soon as you have completed Part One, answer the questions in Part Two.', 4, 1, 0, 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `test_topic_metadata`
--

CREATE TABLE IF NOT EXISTS `test_topic_metadata` (
  `sectionId` char(36) NOT NULL COMMENT 'unique ID for each section - which identifies the test type and section name',
  `topicName` varchar(50) NOT NULL,
  `topicInstructions` varchar(500) NOT NULL,
  `topicNumQuestions` int(11) NOT NULL,
  KEY `sectionId` (`sectionId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_topic_metadata`
--

INSERT INTO `test_topic_metadata` (`sectionId`, `topicName`, `topicInstructions`, `topicNumQuestions`) VALUES
('9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SYNONYMS', 'Each question in Part One consists of a word in capital letters followed by four answer choices. Select the one word that is most nearly the same in meaning as the word in capital letters.', 15),
('9b07ad26-1491-11e2-87f7-9b085696ecdc', 'SENTENCE_COMPLETION', 'Directions: Select the word or phrase that best completes the sentence.', 15),
('e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ARITHMETIC', '', 13),
('e1dd123e-3c48-11e2-8eff-86b90e19545a', 'ALGEBRA', '', 7),
('e1dd123e-3c48-11e2-8eff-86b90e19545a', 'GEOMETRY', '', 10),
('9189bb68-1491-11e2-87f7-9b085696ecdc', 'MATH_CONCEPT', '', 3),
('9189bb68-1491-11e2-87f7-9b085696ecdc', 'MATH_APPLICATION', '', 1),
('599efc34-301d-11e2-a434-5958ac5abb9c', 'READING_COMP', '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `uacc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uacc_group_fk` smallint(5) unsigned NOT NULL,
  `uacc_email` varchar(100) NOT NULL,
  `uacc_username` varchar(15) NOT NULL,
  `uacc_password` varchar(60) NOT NULL,
  `uacc_ip_address` varchar(40) NOT NULL,
  `uacc_salt` varchar(40) NOT NULL,
  `uacc_activation_token` varchar(40) NOT NULL,
  `uacc_forgotten_password_token` varchar(40) NOT NULL,
  `uacc_forgotten_password_expire` datetime NOT NULL,
  `uacc_update_email_token` varchar(40) NOT NULL,
  `uacc_update_email` varchar(100) NOT NULL,
  `uacc_active` tinyint(1) unsigned NOT NULL,
  `uacc_suspend` tinyint(1) unsigned NOT NULL,
  `uacc_fail_login_attempts` smallint(5) NOT NULL,
  `uacc_fail_login_ip_address` varchar(40) NOT NULL,
  `uacc_date_fail_login_ban` datetime NOT NULL COMMENT 'Time user is banned until due to repeated failed logins',
  `uacc_date_last_login` datetime NOT NULL,
  `uacc_date_added` datetime NOT NULL,
  PRIMARY KEY (`uacc_id`),
  UNIQUE KEY `uacc_id` (`uacc_id`),
  KEY `uacc_group_fk` (`uacc_group_fk`),
  KEY `uacc_email` (`uacc_email`),
  KEY `uacc_username` (`uacc_username`),
  KEY `uacc_fail_login_ip_address` (`uacc_fail_login_ip_address`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`uacc_id`, `uacc_group_fk`, `uacc_email`, `uacc_username`, `uacc_password`, `uacc_ip_address`, `uacc_salt`, `uacc_activation_token`, `uacc_forgotten_password_token`, `uacc_forgotten_password_expire`, `uacc_update_email_token`, `uacc_update_email`, `uacc_active`, `uacc_suspend`, `uacc_fail_login_attempts`, `uacc_fail_login_ip_address`, `uacc_date_fail_login_ban`, `uacc_date_last_login`, `uacc_date_added`) VALUES
(1, 1, 'mayamisner@gmail.com', '', '$2a$08$8NeAuj6qTMPGaEESiD78XeQKJhSc52Oyz71kgh9.rZinv35kFGaeC', '0.0.0.0', '6P87p9CPV', '', '', '0000-00-00 00:00:00', '', '', 1, 0, 0, '', '0000-00-00 00:00:00', '2013-06-24 23:47:16', '2013-06-24 17:42:22'),
(2, 2, 'maya.srinivasan@oracle.com', '', '$2a$08$vJ.BoYG6aWl03mu4KdBjluQa41PY.wO5LzUJBk7118zRhQFdCpAFy', '0.0.0.0', 'CFdvjHJpP', '', '', '0000-00-00 00:00:00', '', '', 1, 0, 0, '', '0000-00-00 00:00:00', '2013-06-24 23:46:52', '2013-06-24 17:42:25'),
(3, 2, 'blabber1000@gmail.com', '', '$2a$08$NXaEnrW8a1hBg9SBc7m.Tedx0HnMufYtQamOsYqF78qKwC7PLFCZG', '0.0.0.0', 'trpwsXs6C', '24ca91ff5348abe53a41e6366fa1f542b1ad2a4d', '', '0000-00-00 00:00:00', '', '', 0, 0, 0, '', '0000-00-00 00:00:00', '2013-06-24 22:34:21', '2013-06-24 22:34:21'),
(4, 2, 'starblankie@gmail.com', '', '$2a$08$GbNQyXAegIspvq2sgIyvZe0sMfxLkjdISENxiqITMCNPo7qxUYr3G', '0.0.0.0', 'xkk6JvhVT', 'a9c5da47c03111322fa82b5d7b87de74f065cabf', '', '0000-00-00 00:00:00', '', '', 0, 0, 0, '', '0000-00-00 00:00:00', '2013-06-24 22:36:49', '2013-06-24 22:36:49'),
(5, 1, 'stormyseas@gmail.com', '', '$2a$08$1Dyjr6ubMIX6cfjkqRryteGF0p2S3bmj/Z4dh4IPHg8hIe4z72x1a', '0.0.0.0', 'qcYnH9rSr', '35be7b0f154be4d0f921fdaf4027495688b26e16', '', '0000-00-00 00:00:00', '', '', 0, 0, 0, '', '0000-00-00 00:00:00', '2013-06-24 22:46:33', '2013-06-24 22:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `ugrp_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `ugrp_name` varchar(20) NOT NULL,
  `ugrp_desc` varchar(100) NOT NULL,
  `ugrp_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`ugrp_id`),
  UNIQUE KEY `ugrp_id` (`ugrp_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`ugrp_id`, `ugrp_name`, `ugrp_desc`, `ugrp_admin`) VALUES
(1, 'Parent', 'Parent user: can view all children reports; cannot take a test. Can administer family details', 0),
(2, 'Student', 'Student user: Can view own reports and take tests', 1),
(3, 'Master Admin', 'Master Admin : has full admin access rights.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_sessions`
--

CREATE TABLE IF NOT EXISTS `user_login_sessions` (
  `usess_uacc_fk` int(11) NOT NULL,
  `usess_series` varchar(40) NOT NULL,
  `usess_token` varchar(40) NOT NULL,
  `usess_login_date` datetime NOT NULL,
  PRIMARY KEY (`usess_token`),
  UNIQUE KEY `usess_token` (`usess_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_privileges`
--

CREATE TABLE IF NOT EXISTS `user_privileges` (
  `upriv_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_name` varchar(20) NOT NULL,
  `upriv_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`upriv_id`),
  UNIQUE KEY `upriv_id` (`upriv_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_privileges`
--

INSERT INTO `user_privileges` (`upriv_id`, `upriv_name`, `upriv_desc`) VALUES
(1, 'View Users', 'User can view user account details.'),
(2, 'View User Groups', 'User can view user groups.'),
(3, 'View Privileges', 'User can view privileges.'),
(4, 'Insert User Groups', 'User can insert new user groups.'),
(5, 'Insert Privileges', 'User can insert privileges.'),
(6, 'Update Users', 'User can update user account details.'),
(7, 'Update User Groups', 'User can update user groups.'),
(8, 'Update Privileges', 'User can update user privileges.'),
(9, 'Delete Users', 'User can delete user accounts.'),
(10, 'Delete User Groups', 'User can delete user groups.'),
(11, 'Delete Privileges', 'User can delete user privileges.');

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege_groups`
--

CREATE TABLE IF NOT EXISTS `user_privilege_groups` (
  `upriv_groups_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `upriv_groups_ugrp_fk` smallint(5) unsigned NOT NULL,
  `upriv_groups_upriv_fk` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`upriv_groups_id`),
  UNIQUE KEY `upriv_groups_id` (`upriv_groups_id`) USING BTREE,
  KEY `upriv_groups_ugrp_fk` (`upriv_groups_ugrp_fk`),
  KEY `upriv_groups_upriv_fk` (`upriv_groups_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user_privilege_groups`
--

INSERT INTO `user_privilege_groups` (`upriv_groups_id`, `upriv_groups_ugrp_fk`, `upriv_groups_upriv_fk`) VALUES
(1, 3, 1),
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 3, 10),
(11, 3, 11),
(12, 2, 2),
(13, 2, 4),
(14, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege_users`
--

CREATE TABLE IF NOT EXISTS `user_privilege_users` (
  `upriv_users_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `upriv_users_uacc_fk` int(11) NOT NULL,
  `upriv_users_upriv_fk` smallint(5) NOT NULL,
  PRIMARY KEY (`upriv_users_id`),
  UNIQUE KEY `upriv_users_id` (`upriv_users_id`) USING BTREE,
  KEY `upriv_users_uacc_fk` (`upriv_users_uacc_fk`),
  KEY `upriv_users_upriv_fk` (`upriv_users_upriv_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `user_privilege_users`
--

INSERT INTO `user_privilege_users` (`upriv_users_id`, `upriv_users_uacc_fk`, `upriv_users_upriv_fk`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 2, 1),
(13, 2, 2),
(14, 2, 3),
(15, 2, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
