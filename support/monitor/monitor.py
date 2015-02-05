# -*- coding: utf-8 -*-

import sys
import time
import os
import psutil
import json
import ConfigParser

from twisted.internet import reactor
from autobahn.twisted.websocket import WebSocketServerFactory, WebSocketServerProtocol, listenWS

os.environ["TZ"] = "Asia/Shanghai"
time.tzset()
config = ConfigParser.ConfigParser()

class BroadcastServerProtocol(WebSocketServerProtocol):
	def onOpen(self):
		self.factory.register(self)

	def connectionLost(self, reason):
		WebSocketServerProtocol.connectionLost(self, reason)
		self.factory.unregister(self)


class BroadcastServerFactory(WebSocketServerFactory):
	def __init__(self, url, debug = False, debugCodePaths = False):
		WebSocketServerFactory.__init__(self, url, debug = debug, debugCodePaths = debugCodePaths)
		self.clients = []
		self.tick()

	def register(self, client):
		if not client in self.clients:
			self.clients.append(client)

	def unregister(self, client):
		if client in self.clients:
			self.clients.remove(client)

	def broadcast(self, msg):
		for c in self.clients:
			c.sendMessage(msg)
			
	def tick(self):
		cpu_usage      = psutil.cpu_percent(interval=1, percpu=True)
		virtual_memory = psutil.virtual_memory()
		network        = psutil.network_io_counters()
		
		sys_info = json.dumps({
			"timestamp"	: time.time()*1000,
			"cpu"		: cpu_usage,
			"memory"	: [virtual_memory.used/(1024**2), virtual_memory.available/(1024**2)],
			"network"	: [network.bytes_sent, network.bytes_recv]
		})
		self.broadcast(sys_info)
		reactor.callLater(0.1, self.tick)

if __name__ == "__main__":
	if len(sys.argv) > 1 and sys.argv[1] == "debug":
		debug = True
	else:
		debug = False

	ServerFactory = BroadcastServerFactory

	try:
		rp = os.path.realpath(__file__)
		config.read(os.path.dirname(os.path.dirname(rp))+"/config.ini")
		factory = ServerFactory("ws://localhost:"+config.get("monitor", "port"), debug = debug, debugCodePaths = debug)
		#factory = ServerFactory("ws://localhost:8889", debug = debug, debugCodePaths = debug)

	except:
		exit()

	factory.protocol = BroadcastServerProtocol
	factory.setProtocolOptions(allowHixie76 = True)
	listenWS(factory)

	reactor.run()
