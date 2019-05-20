from selenium.webdriver import Firefox 
from selenium.webdriver.firefox.options import Options

class FF_Test():

	def debugComment (self,strComment):
		print ("-- " + strComment)
		
	def __init__(self): 
	
		opts = Options()
		#opts.headless = True
		self.browser = Firefox(options=opts)
		
		self.BaseURL="http://localhost/Cadence/"
		self.Username="Selenium"
		self.Password="pass_w0rd"
		self.wait = 2

	def log_in(self):
		LoginURL = self.BaseURL + "login.php"
		browser=self.browser

		self.debugComment ("Authenticating")
		browser.get(LoginURL)
		browser.implicitly_wait(self.wait)

		UsernameField = browser.find_element_by_name("uname")
		UsernameField.send_keys(self.Username)

		passwordField = browser.find_element_by_name("passwd")
		passwordField.send_keys(self.Password)

		loginButton = browser.find_element_by_name("btnSubmit")
		loginButton.click()

		OKMessage = browser.find_element_by_name("successOK")
		self.debugComment ("Successfully logged in")
		
	def read_main_page(self):

		browser=self.browser
		RemindersURL = self.BaseURL + "reminders.php"

		browser.get(RemindersURL)
		browser.implicitly_wait(self.wait)
		if "caught up" in browser.page_source:
			self.debugComment ("caught up")
		elif "Current" in browser.page_source:
			self.debugComment ("You have one or more current reminders.")

		else:
			self.debugComment ("Error reading page.")

	def create_reminder(self,strTitle):
		self.debugComment ("Creating reminder with title: " + strTitle)
	
		browser=self.browser
		newReminderURL = self.BaseURL + "edit_reminder.php?ID=new"

		browser.get(newReminderURL)
		browser.implicitly_wait(self.wait)	

		titleField = browser.find_element_by_name("title")
		titleField.send_keys(strTitle)

		submitButton = browser.find_element_by_name("btnSubmit")
		submitButton.click()

	
	def create_dummy_reminders(self):
		self.create_reminder("Dummy1")
		self.create_reminder("Dummy2")
		self.create_reminder("Dummy3")
		self.create_reminder("Dummy4")
		self.create_reminder("Dummy5")

	def main(self):

		self.log_in()
		self.read_main_page()
		self.create_dummy_reminders()
		self.browser.close()
		quit()
			
			
ff = FF_Test()
ff.main()
