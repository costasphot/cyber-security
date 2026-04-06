	1. Download the links:
curl -O https://downloads.apache.org/cassandra/5.0.7/apache-cassandra-5.0.7-src.tar.gz
curl -O https://downloads.apache.org/cassandra/5.0.7/apache-cassandra-5.0.7-src.tar.gz.sha512

	2. Run the command (on Windows):
certUtil -hashfile apache-cassandra-5.0.7-src.tar.gz SHA512

	3. If the SHA512 downloaded with the result of the command are the same:
- Using the command (locally): 36c74b0c9e49a7686ca6826f0ec3f30a9e365ff2f561c4596c34dd0d2c63ea1bc7a23d7e744da90d2a62dc5eb4f5cd0d55823d919b7167b324526bf6c1756bd8
- Using the website (remotely): 36c74b0c9e49a7686ca6826f0ec3f30a9e365ff2f561c4596c34dd0d2c63ea1bc7a23d7e744da90d2a62dc5eb4f5cd0d55823d919b7167b324526bf6c1756bd8