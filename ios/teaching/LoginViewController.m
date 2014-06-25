//
//  LoginViewController.m
//  teaching
//
//  Created by kidliuxu on 14-1-6.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "LoginViewController.h"
#import "DDMenuController.h"
#import "ProfileViewController.h"
#import "NavController.h"
#import "CourseLogsViewController.h"


@interface LoginViewController ()

@end

@implementation LoginViewController

@synthesize rightBtnType,usernameField,passwordField, tapGr, callbackDelegate, courseUrl;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self)
    {
        // Custom initialization
    }
    return self;
}
-(id) initWithMenuBtn
{
    self = [super init];
    if(self)
    {
        self.rightBtnType = 0;
    }
    return self;}
-(id) initWithBackBtn
{
    self = [super init];
    if(self)
    {
        self.rightBtnType = 1;
    }
    return self;
}

- (id) initWithUrl:(NSURL *) url
{
    self = [super init];
    if(self)
    {
        self.courseUrl = url;
    }
    return self;
}

- (void) setDelegate:(id<LoginCallbackDelegate>)delegate
{
    self.callbackDelegate = delegate;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self setNavTitle:@"登录"];
    isClickRegist = false;
    if(self.rightBtnType == 0)
        [self addMenuButton];
    if(self.rightBtnType == 1)
    {
        [self addBackButton];
    }
	
    [self initScrolView];

    self.tapGr = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(viewTapped:)];
    self.tapGr.cancelsTouchesInView = NO;
    [self.view addGestureRecognizer:self.tapGr];
    
    UIView *contentView = [[UIView alloc]initWithFrame:CGRectMake(0, 0, 320, 454)];
    
    [self.scrolView setBackgroundColor:[UIColor colorWithRed:231.0/255.0 green:231.0/255.0 blue:231.0/255.0 alpha:1.0]];
    
    UIImageView *loginbg = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"loginbg"]];
    
    loginbg.frame = CGRectMake((320-loginbg.frame.size.width)/2.0, 12, loginbg.frame.size.width, loginbg.frame.size.height);
    loginbg.userInteractionEnabled = YES;
    
    UILabel *label1 = [[UILabel alloc]initWithFrame:CGRectMake(9, 12, 100, 20)];
    label1.text = @"Email邮箱";
    label1.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
    label1.font = [UIFont systemFontOfSize:18];
    [loginbg addSubview: label1];
    
    UILabel *label2 = [[UILabel alloc]initWithFrame:CGRectMake(9, 90, 100, 20)];
    label2.text = @"密码";
    label2.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
    label2.font = [UIFont systemFontOfSize:18];
    [loginbg addSubview: label2];
    
    
    UITextField *usernameInput = [[UITextField alloc]initWithFrame:CGRectMake(20,48, 280, 23)];
    usernameInput.placeholder = @"输入注册时填写的邮箱";
    usernameInput.text = @"12@qq.com";
    usernameInput.delegate = self;
    usernameInput.returnKeyType = UIReturnKeyDone;
    usernameInput.font = [UIFont systemFontOfSize:15];
    [loginbg addSubview:usernameInput];
    
    self.usernameField = usernameInput;
    
    [usernameInput release];
    
    UITextField *passwdInput = [[UITextField alloc]initWithFrame:CGRectMake(20,130, 280, 23)];
    passwdInput.secureTextEntry = YES;
    passwdInput.returnKeyType = UIReturnKeyDone;
    passwdInput.placeholder = @"输入密码";
    passwdInput.text = @"123456";
    passwdInput.delegate = self;
    passwdInput.font = [UIFont systemFontOfSize:15];
    [loginbg addSubview:passwdInput];
    self.passwordField = passwdInput;
    [passwdInput release];
    
    [contentView addSubview: loginbg];
    
    
    UIButton *loginbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    loginbtn.frame = CGRectMake(loginbg.frame.origin.x,loginbg.frame.origin.y+loginbg.frame.size.height, 304, 53) ;
    [loginbtn setBackgroundImage:[UIImage imageNamed:@"loginbtn"] forState:UIControlStateNormal];
    
    [loginbtn addTarget:self action:@selector(didLoginBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
    
    
    [contentView addSubview: loginbtn];
    
    UILabel *label3 = [[UILabel alloc]initWithFrame:CGRectMake(loginbg.frame.origin.x, loginbtn.frame.size.height + loginbtn.frame.origin.y + 14,304,20)];
    label3.text = @"使用其它方式登录";
    label3.textColor = [UIColor colorWithRed:123.0/255.0 green:152.0/255.0 blue:180.0/255.0 alpha:1.0];
    label3.font = [UIFont systemFontOfSize:18];
    [contentView addSubview: label3];
    
    
    UIButton *qqLoginBtn = [UIButton buttonWithType:UIButtonTypeCustom];
    qqLoginBtn.frame = CGRectMake(loginbg.frame.origin.x,label3.frame.origin.y+label3.frame.size.height + 14, 304, 53) ;
    [qqLoginBtn setBackgroundImage:[UIImage imageNamed:@"qqloginbtn.png"] forState:UIControlStateNormal];
    [qqLoginBtn addTarget:self action:@selector(didqqLoginBtnClicked:) forControlEvents:UIControlEventTouchUpInside];

    [contentView addSubview:qqLoginBtn];

    UIButton *regbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    regbtn.frame = CGRectMake(loginbg.frame.origin.x, qqLoginBtn.frame.origin.y + qqLoginBtn.frame.size.height + 14, 304, 53);
    [regbtn setBackgroundImage:[UIImage imageNamed:@"regbtn"] forState:UIControlStateNormal];
    [regbtn addTarget:self action:@selector(didRegButtonClicked:) forControlEvents:UIControlEventTouchUpInside];

    [contentView addSubview: regbtn];
    
    [self.scrolView addSubview:contentView];
    [self.scrolView setContentSize:CGSizeMake(320,contentView.frame.size.height)];
    [self.view addSubview: self.scrolView];
    
    waitView = [[WaitView alloc] initWithParentView:self.view ];

    _permissions = [[NSArray arrayWithObjects:
                     kOPEN_PERMISSION_GET_USER_INFO,
                     kOPEN_PERMISSION_GET_SIMPLE_USER_INFO,
                     kOPEN_PERMISSION_ADD_ALBUM,
                     kOPEN_PERMISSION_ADD_IDOL,
                     kOPEN_PERMISSION_ADD_ONE_BLOG,
                     kOPEN_PERMISSION_ADD_PIC_T,
                     kOPEN_PERMISSION_ADD_SHARE,
                     kOPEN_PERMISSION_ADD_TOPIC,
                     kOPEN_PERMISSION_CHECK_PAGE_FANS,
                     kOPEN_PERMISSION_DEL_IDOL,
                     kOPEN_PERMISSION_DEL_T,
                     kOPEN_PERMISSION_GET_FANSLIST,
                     kOPEN_PERMISSION_GET_IDOLLIST,
                     kOPEN_PERMISSION_GET_INFO,
                     kOPEN_PERMISSION_GET_OTHER_INFO,
                     kOPEN_PERMISSION_GET_REPOST_LIST,
                     kOPEN_PERMISSION_LIST_ALBUM,
                     kOPEN_PERMISSION_UPLOAD_PIC,
                     kOPEN_PERMISSION_GET_VIP_INFO,
                     kOPEN_PERMISSION_GET_VIP_RICH_INFO,
                     kOPEN_PERMISSION_GET_INTIMATE_FRIENDS_WEIBO,
                     kOPEN_PERMISSION_MATCH_NICK_TIPS_WEIBO,
                     nil] retain];

    NSString *appid = @"101035302";

	_tencentOAuth = [[TencentOAuth alloc] initWithAppId:appid andDelegate:self];
    
}

- (void)viewWillAppear:(BOOL)animated
{
    [self loadUser];
    //NSLog(@"login view will appear isguest %d", [self isGuest]);
    if(![self isGuest])
    {
        //NSLog(@"已注册的用户 %@", self.navigationController);

        DDMenuController *menuController = (DDMenuController*)((AppDelegate*)[[UIApplication sharedApplication] delegate]).menuController;
        CourseLogsViewController *ctl = [[CourseLogsViewController alloc] init];
        NavController *nav = [[NavController alloc]initWithRootViewController:ctl];
        [menuController setRootController:nav animated:YES];
    }
}

// Override to allow orientations other than the default portrait orientation.
- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation {
    return YES;
}

// Override to allow orientations other than the default portrait orientation ios6.0
-(NSUInteger)supportedInterfaceOrientations{
    return UIInterfaceOrientationMaskAll;
}

- (BOOL)shouldAutorotate
{
    return YES;
}

-(void)viewTapped:(UITapGestureRecognizer*)_tapGr
{
    NSLog(@"viewTapped");
    [self.usernameField resignFirstResponder];
    [self.passwordField resignFirstResponder];
}

//点击回车按钮
- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
    [self startLogin];
    return YES;
}

- (void) didRegButtonClicked:(id) sender
{
    RegistViewController *loginview = [[RegistViewController alloc]init];
    [self.navigationController pushViewController:loginview animated:YES];
    [loginview release];
}

- (void)didLoginBtnClicked:(id)sender
{
    [self startLogin];
}

- (void)didqqLoginBtnClicked:(id)sender
{
    [_tencentOAuth authorize:_permissions inSafari:NO];
}

- (void)tencentDidLogin {
	// 登录成功
	//_labelTitle.text = @"登录完成";
    NSLog(@"登录完成");

    if (_tencentOAuth.accessToken
        && 0 != [_tencentOAuth.accessToken length])
    {
        //_labelAccessToken.text = _tencentOAuth.accessToken;
        NSLog(@"登录成功，accesstoken is: %@", _tencentOAuth.accessToken);
        NSLog(@"登录成功，openid is: %@", _tencentOAuth.openId);
        //[_tencentOAuth getUserInfo];
        ASIFormDataRequest *request = [ASIFormDataRequest requestWithURL:[NSURL URLWithString: APIMAKER(API_URL_QQLOGIN)]];
        [request setRequestMethod:@"POST"];

        [request setPostValue:_tencentOAuth.openId forKey:@"openid"];
        [request setPostValue:@"QQ" forKey:@"type"];

        NSLog(@"%@", request.url);
        request.delegate = self;

        [request startAsynchronous];
        
        [waitView show];
        
    }
    else
    {
        //_labelAccessToken.text = @"登录不成功 没有获取accesstoken";
        NSLog(@"登录不成功 没有获取accesstoken");
    }
}

- (void)getUserInfoResponse:(APIResponse*) response
{
    if(nil == response)
    {
        NSLog(@"无数据");
        return;
    }

    NSLog(@"response code is: %@", response.userData);
}


/**
 * Called when the user dismissed the dialog without logging in.
 */
- (void)tencentDidNotLogin:(BOOL)cancelled
{
	if (cancelled){
		//_labelTitle.text = @"用户取消登录";
        NSLog(@"用户取消登录");
	}
	else {
		//_labelTitle.text = @"登录失败";
        NSLog(@"登录失败");
	}

}

/**
 * Called when the notNewWork.
 */
-(void)tencentDidNotNetWork
{
	//_labelTitle.text=@"无网络连接，请设置网络";
    NSLog(@"无网络连接，请设置网络");
}

- (void) startLogin
{
    NSLog(@"username: %@ password: %@",self.usernameField.text, self.passwordField.text);

    if (![self.usernameField.text isEqualToString:@"" ]&& ![self.passwordField.text isEqualToString:@""])
    {
        NSString *uuid = [self getUDID] ;
        ASIFormDataRequest *request = [ASIFormDataRequest requestWithURL:[NSURL URLWithString: APIMAKER(API_URL_LOGIN)]];
        [request setRequestMethod:@"POST"];

        [request setPostValue:uuid forKey:@"uuid"];
        [request setPostValue:self.usernameField.text forKey:@"email"];
        [request setPostValue:[self.passwordField.text URLEncodedString] forKey:@"password"];


        NSLog(@"%@", APIMAKER(API_URL_LOGIN));
        request.delegate = self;

        [request startAsynchronous];

        [waitView show];

        [self.usernameField resignFirstResponder];
        [self.passwordField resignFirstResponder];

    }
    else
    {

        [self showAlertByTitle:@"Error" withMessage:@"请输入邮箱和密码"];
    }
}

- (void)requestFinished:(ASIHTTPRequest *)request
{
    NSString *responseString = [request responseString];
    NSLog(@"%@", responseString);
    NSLog(@"login ret: %@", [responseString JSONValue]);
    
    [waitView hide];
    NSDictionary *userloginret = [[responseString JSONValue] objectForKey:@"retinfo"];
    
    if([[[responseString JSONValue] objectForKey:@"ret"] intValue] == 1)
    {
        
        NSLog(@"login ok");

        NSDictionary *userinfo = [userloginret objectForKey:@"userinfo"];
        self.member = userinfo;
        [self saveUser];
        //DDMenuController *menuController = (DDMenuController*)((AppDelegate*)[[UIApplication sharedApplication] delegate]).menuController;
        NSLog(@"已注册的用户 %@", self.navigationController);

       // [self.navigationController popViewControllerAnimated:YES];

        [self goBack:self];
    }
    else
    {
        [self showAlertByTitle:@"Error" withMessage:[userloginret objectForKey:@"errormsg"]];
    }
}

- (void) dealloc
{
    [self.view removeGestureRecognizer:self.tapGr];
    [self.tapGr release];
    [super dealloc];
    //NSLog(@"tapGr: %d", tapGr);

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
