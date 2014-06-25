//
//  RegistViewController.m
//  teaching
//
//  Created by kidliuxu on 14-1-6.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "RegistViewController.h"

@interface RegistViewController ()

@end

@implementation RegistViewController

@synthesize tapGr, usernameField, passwordField, rePasswordField, emailField, departmentBtn, departmentIdList, departmentNameList;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self setNavTitle:@"注册"];
    [self addBackButton];
    [self initScrolView];
    [self initViewController];
    if(TARGET_VERSION_LITE == APPTYPE_LXHG)
    {
        [self startLoadDepartmentInfo];
    }
	// Do any additional setup after loading the view.
}

//读取部门信息
- (void) startLoadDepartmentInfo
{
    ASIFormDataRequest *request = [ASIFormDataRequest requestWithURL:[NSURL URLWithString: APIMAKER(API_URL_DEPARTMENT)]];
    [request setRequestMethod:@"GET"];
    NSLog(@"%@", request.url);
    request.delegate = self;
    [request startAsynchronous];
    [waitView show];
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
        NSString *type = [userloginret objectForKey:@"retinfotype"];
        NSLog(@"type %@", type);
        if([type isEqualToString:@"getAllDepartment"])
        {
            [self didLoadDepartmentComplete:[userloginret objectForKey:@"list"]];
        }
        else if([type isEqualToString:@"Registration"])
        {
            NSDictionary *userinfo = [userloginret objectForKey:@"userinfo"];
            //NSString *sid = [[userloginret objectForKey:@"userinfo"] objectForKey:@"sid"];
            NSLog(@"注册 %@", [userinfo valueForKey:@"sid"]);
            self.member = userinfo;
            [self saveUser];
            [self goBack:self];
        }
    }
    else
    {
        //[self showAlertByTitle:@"Error" withMessage:@"请输入邮箱和密码"];
        NSString *errorMsg = [userloginret objectForKey:@"errormsg"];
        [self showAlertViewByMsg:errorMsg];
    }
}

- (void) initViewController
{
    self.tapGr = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(viewTapped:)];
    self.tapGr.cancelsTouchesInView = NO;
    [self.view addGestureRecognizer:self.tapGr];

    waitView = [[WaitView alloc] initWithParentView:self.view ];

    NSString *bgName = @"registBG.png";
    if(TARGET_VERSION_LITE == APPTYPE_LXHG)
    {
        bgName = @"lxregistBG.png";
    }

    NSString *userNamePlaceholderStr = @"输入您的昵称";
    NSString *nickNameLabelStr = @"昵称";
    contentViewHeight = 420;
    if(TARGET_VERSION_LITE == APPTYPE_LXHG)
    {
        userNamePlaceholderStr = @"输入您的真实姓名";
        nickNameLabelStr = @"真实姓名";
        contentViewHeight = 507;
    }

    UIView *contentView = [[UIView alloc]initWithFrame:CGRectMake(0, 0, 320, contentViewHeight)];
    [self.scrolView setBackgroundColor:[UIColor colorWithRed:231.0/255.0 green:231.0/255.0 blue:231.0/255.0 alpha:1.0]];

    //背景
    UIImageView *loginbg = [[UIImageView alloc]initWithImage:[UIImage imageNamed:bgName]];
    loginbg.frame = CGRectMake((320-loginbg.frame.size.width)/2.0, 12, loginbg.frame.size.width, loginbg.frame.size.height);
    loginbg.userInteractionEnabled = YES;
    [contentView addSubview: loginbg];

    UILabel *emailLabel = [[UILabel alloc]initWithFrame:CGRectMake(9, 12, 100, 20)];
    emailLabel.text = @"登录邮箱";
    emailLabel.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
    emailLabel.font = [UIFont systemFontOfSize:18];
    [loginbg addSubview: emailLabel];
    [emailLabel release];

    UILabel *passwordLabel = [[UILabel alloc]initWithFrame:CGRectMake(9, 95, 100, 20)];
    passwordLabel.text = @"密码";
    passwordLabel.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
    passwordLabel.font = [UIFont systemFontOfSize:18];
    [loginbg addSubview: passwordLabel];

    UILabel *rePasswordLabel = [[UILabel alloc]initWithFrame:CGRectMake(9, 178, 100, 20)];
    rePasswordLabel.text = @"确认密码";
    rePasswordLabel.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
    rePasswordLabel.font = [UIFont systemFontOfSize:18];
    [loginbg addSubview: rePasswordLabel];

    UILabel *nickNameLabel = [[UILabel alloc]initWithFrame:CGRectMake(9, 261, 100, 20)];
    nickNameLabel.text = nickNameLabelStr;
    nickNameLabel.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
    nickNameLabel.font = [UIFont systemFontOfSize:18];
    [loginbg addSubview: nickNameLabel];
    [nickNameLabel release];

    UITextField *emailInput = [[UITextField alloc]initWithFrame:CGRectMake(20,38, 270, 44)];
    emailInput.placeholder = @"输入您用于登录的邮箱";
    //emailInput.text = @"kidliu@gg.cn";
    emailInput.delegate = self;
    emailInput.returnKeyType = UIReturnKeyDone;
    emailInput.font = [UIFont systemFontOfSize:15];
    [loginbg addSubview:emailInput];
    self.emailField = emailInput;
    [emailInput release];

    UITextField *passwordInput = [[UITextField alloc] initWithFrame:CGRectMake(20, 124, 270, 44)];
    passwordInput.placeholder = @"输入您的密码";
    passwordInput.secureTextEntry = YES;
    //passwordInput.text = @"12";
    passwordInput.delegate = self;
    passwordInput.returnKeyType = UIReturnKeyDone;
    passwordInput.font = [UIFont systemFontOfSize:15];
    [loginbg addSubview:passwordInput];
    self.passwordField = passwordInput;
    [passwordInput release];

    UITextField *rePasswordInput = [[UITextField alloc] initWithFrame:CGRectMake(20, 208, 270, 44)];
    rePasswordInput.placeholder = @"再次输入您的密码";
    //rePasswordInput.text = @"12";
    rePasswordInput.secureTextEntry = YES;
    rePasswordInput.delegate = self;
    rePasswordInput.returnKeyType = UIReturnKeyDone;
    rePasswordInput.font = [UIFont systemFontOfSize:15];
    [loginbg addSubview:rePasswordInput];
    self.rePasswordField = rePasswordInput;
    [rePasswordInput release];

    UITextField *usernameInput = [[UITextField alloc]initWithFrame:CGRectMake(20,293, 270, 44)];
    usernameInput.placeholder = userNamePlaceholderStr;
    //usernameInput.text = @"kidliu";
    usernameInput.delegate = self;
    usernameInput.returnKeyType = UIReturnKeyDone;
    usernameInput.font = [UIFont systemFontOfSize:15];
    [loginbg addSubview:usernameInput];
    self.usernameField = usernameInput;
    [usernameInput release];

    if(TARGET_VERSION_LITE == APPTYPE_LXHG)
    {
        UILabel *departmentLabel = [[UILabel alloc]initWithFrame:CGRectMake(9, 344, 100, 20)];
        departmentLabel.text = @"部门";
        departmentLabel.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
        departmentLabel.font = [UIFont systemFontOfSize:18];
        [loginbg addSubview: departmentLabel];
        [departmentLabel release];
        /*
        UILabel *departmentInput = [[UILabel alloc]initWithFrame:CGRectMake(12, 386, 275, 20)];
        departmentInput.text = @"请选择您的部门";
        departmentInput.textColor = [UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0];
        departmentInput.font = [UIFont systemFontOfSize:18];
        [loginbg addSubview: departmentInput];
        */
        UIButton *tmpDepartmentBtn = [UIButton buttonWithType:UIButtonTypeCustom];
        tmpDepartmentBtn.frame = CGRectMake(20, 376, 270, 44);
        tmpDepartmentBtn.tag = -1;
        [tmpDepartmentBtn setTitle:@"请选择您的部门" forState:UIControlStateNormal];
        tmpDepartmentBtn.titleLabel.font = [UIFont systemFontOfSize:18];
        [tmpDepartmentBtn setTitleColor:[UIColor colorWithRed:46.0/255.0 green:46.0/255.0 blue:46.0/255.0 alpha:1.0] forState:UIControlStateNormal];
        [tmpDepartmentBtn addTarget:self action:@selector(didDepartmentClicked:) forControlEvents:UIControlEventTouchUpInside];
        [loginbg addSubview:tmpDepartmentBtn];
        self.departmentBtn = tmpDepartmentBtn;
        [tmpDepartmentBtn release];

        departmentID = @"";

    }
    //确认按钮
    UIButton *submitbtn = [UIButton buttonWithType:UIButtonTypeCustom];
    submitbtn.frame = CGRectMake(loginbg.frame.origin.x, loginbg.frame.origin.y + loginbg.frame.size.height, 304, 53);
    [submitbtn setBackgroundImage:[UIImage imageNamed:@"submitBtnBG.png"] forState:UIControlStateNormal];
    [submitbtn setTitle:@"确认" forState:UIControlStateNormal];
    submitbtn.titleLabel.font = [UIFont systemFontOfSize:30];
    [submitbtn addTarget:self action:@selector(didSubmitButtonClicked:) forControlEvents:UIControlEventTouchUpInside];
    [contentView addSubview: submitbtn];

    [self.scrolView addSubview:contentView];
    scrolViewHeight = self.scrolView.frame.size.height;
    NSLog(@"scrolViewHeight: %i", scrolViewHeight);
    [self.scrolView setContentSize:CGSizeMake(320,contentView.frame.size.height)];
    [self.view addSubview: self.scrolView];

    //键盘显示事件
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardWillShow:) name:UIKeyboardWillShowNotification object:nil];
    [[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(keyboardWillHeide:) name:UIKeyboardWillHideNotification object:nil];
}

//开始输入
- (void)textFieldDidBeginEditing:(UITextField *)textField
{
    NSLog(@"开始输入");
    CGRect rect = [[UIScreen mainScreen] bounds];
    CGSize screenSize = rect.size;

    NSTimeInterval animationDuration = 0.30f;
    [UIView beginAnimations:@"ResizeForKeyboard" context:nil];
    [UIView setAnimationDuration:animationDuration];

    CGFloat textFieldY = textField.frame.origin.y;
    //NSLog(@"self.scrolView.frame.size.height: %f", self.scrolView.frame.size.height);
    CGFloat keybroadHeigth = 216;
    CGFloat moveEnd = ((contentViewHeight - (screenSize.height - keybroadHeigth)) + 64) * -1;
    CGFloat moveY = 40 - textFieldY;
    if(moveY > 0)
    {
        moveY = 0;
    }
    else if(moveY < moveEnd)
    {
        moveY = moveEnd;
    }
    NSLog(@"高度: %f, move: %f", screenSize.height - 216, moveY);
    CGRect endRect = CGRectMake(0.0f, moveY, self.scrolView.frame.size.width, contentViewHeight);
    self.scrolView.frame = endRect;
    [UIView commitAnimations];
}

//当键盘显示
- (void)keyboardWillShow:(NSNotification *)aNotification
{
    NSLog(@"keyboardWillShow");
    /*
    CGRect rect = [[UIScreen mainScreen] bounds];
    CGSize size = rect.size;
    NSTimeInterval animationDuration = 0.30f;
    [UIView beginAnimations:@"ResizeForKeyboard" context:nil];
    [UIView setAnimationDuration:animationDuration];
    CGRect endRect = CGRectMake(0.0f, -130, size.width, size.height);
    self.view.frame = endRect;
    //[[CCDirector sharedDirector] view].frame = rect;
    [UIView commitAnimations];
    */
}

//输入完成
-(void)keyboardWillHeide:(NSNotification *)aNotification
{
    NSLog(@"keyboardWillHeide");

    //CGSize size = [[CCDirector sharedDirector] winSize];
    NSTimeInterval animationDuration = 0.30f;
    [UIView beginAnimations:@"ResizeForKeyboard" context:nil];
    [UIView setAnimationDuration:animationDuration];
    NSLog(@"scrolViewHeight: %i", scrolViewHeight);
    NSLog(@"self.scrolView.frame.size.height: %f", self.scrolView.frame.size.height);
    //CGRect rect = CGRectMake(0.0f, 0.0f, self.scrolView.frame.size.width, self.scrolView.frame.size.height);
    CGRect rect = CGRectMake(0.0f, 0.0f, self.scrolView.frame.size.width, scrolViewHeight);
    self.scrolView.frame = rect;
    [UIView commitAnimations];
}

-(void)didDepartmentClicked:(id)sender
{
    NSLog(@"didDepartmentClicked");
    CGRect frame = CGRectMake(0, 0, 320, 240);
    //NSLog(@"tag: %i", self.departmentBtn.tag);
    UIKidPickerView *pickerView = [[UIKidPickerView alloc] initWithFrame:frame pickerViewData:self.departmentNameList];
    [pickerView setCallback:self];
    if(self.departmentBtn.tag >= 0)
    {
        [pickerView setDefaultPickerSelectByID:self.departmentBtn.tag];
    }
    [self.view addSubview:pickerView];
}

-(void)didLoadDepartmentComplete:(NSArray *)dataArray
{
    //NSMutableArray *tmpArray = [NSMutableArray arrayWithObjects:@"部门一", @"部门二",@"部门二",@"部门二",@"部门二",@"部门二",@"部门二",@"部门二", nil];
    //self.departmentList
    NSMutableArray *tempDepartmentList = [[NSMutableArray alloc] init];
    NSMutableArray *tempDepartmentIdList = [[NSMutableArray alloc] init];
    for (NSDictionary *obj in dataArray)
    {
        NSLog(@"obj: %@", [obj objectForKey:@"deparname"]);
        [tempDepartmentList addObject:[obj objectForKey:@"deparname"]];
        [tempDepartmentIdList addObject:[obj objectForKey:@"departmentid"]];
    }
    self.departmentNameList = [[NSArray alloc] initWithArray:tempDepartmentList];
    //self.departmentNameList = [[NSArray alloc] initWithArray:tmpArray];
    self.departmentIdList = [[NSArray alloc] initWithArray:tempDepartmentIdList];
    [tempDepartmentList release];
    [tempDepartmentIdList release];
}

-(void)didChoosePicker:(int) selectID
{
    NSLog(@"did choose picker view is: %i", selectID);
    NSString *chooseName = [self.departmentNameList objectAtIndex:selectID];
    self.departmentBtn.tag = selectID;
    [self.departmentBtn setTitle:chooseName forState:UIControlStateNormal];
    departmentID = [self.departmentIdList objectAtIndex:selectID];
}

-(void)didSubmitButtonClicked:(id)sender
{
    NSLog(@"didSubmitButtonClicked");
    //判断是否有空项
    if(TARGET_VERSION_LITE == APPTYPE_LXHG)
    {
        if ([self.emailField.text isEqualToString:@""] || [self.rePasswordField.text isEqualToString:@""] || [self.passwordField.text isEqualToString:@""] || [self.usernameField.text isEqualToString:@""] || [departmentID isEqualToString:@""])
        {
            NSLog(@"有空项");
            [self showAlertViewByMsg:@"信息请填写完整"];
            return;
        }
    }
    else
    {
        if ([self.emailField.text isEqualToString:@""] || [self.rePasswordField.text isEqualToString:@""] || [self.passwordField.text isEqualToString:@""] || [self.usernameField.text isEqualToString:@""])
        {
            NSLog(@"有空项");
            [self showAlertViewByMsg:@"信息请填写完整"];
            return;
        }
    }
    //判断邮件格式是否正确
    if (![self isValidateEmail:self.emailField.text])
    {
        NSLog(@"邮箱格式不对");
        [self showAlertViewByMsg:@"邮箱格式不正确"];
        return;
    }
    //判断两次密码是否一致
    if(![self.passwordField.text isEqualToString:(self.rePasswordField.text)])
    {
        [self showAlertViewByMsg:@"两次输入密码不一致"];
        return;
    }
    NSLog(@"next -->");
    [self startRegist];
}

-(void)startRegist
{
    ASIFormDataRequest *request = [ASIFormDataRequest requestWithURL:[NSURL URLWithString: APIMAKER(API_URL_REG)]];
    [request setRequestMethod:@"POST"];
    ///email='120@qq.com'&&password='123456'&&username='小席'

    [request setPostValue:self.emailField.text forKey:@"email"];
    [request setPostValue:self.passwordField.text forKey:@"password"];
    [request setPostValue:[self.usernameField.text URLEncodedString] forKey:@"username"];
    [request setPostValue:[departmentID URLEncodedString] forKey:@"deparment"];

    NSLog(@"%@", APIMAKER(API_URL_REG));
    request.delegate = self;

    [request startAsynchronous];

    [waitView show];
}

-(BOOL)isValidateEmail:(NSString *)email
{
    NSString *emailRegex = @"[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,4}";
    NSPredicate *emailTest = [NSPredicate predicateWithFormat:@"SELF MATCHES%@",emailRegex];
    return [emailTest evaluateWithObject:email];
}

-(BOOL)isValidateUsername:(NSString *) username
{
    NSLog(@"username: %@", username);
    NSString *usernameRegex = @"[A-Z0-9a-z]{3,}";
    NSPredicate *usernameTest = [NSPredicate predicateWithFormat:@"SELF MATCHES%@", usernameRegex];
    return [usernameTest evaluateWithObject:username];
}

- (void)showAlertViewByMsg:(NSString *) msg
{
    NSLog(@"msg is : %@", msg);
    UIAlertView*alert = [[UIAlertView alloc]initWithTitle:@"提示"
                                                  message:msg
                                                 delegate:nil
                                        cancelButtonTitle:@"OK"
                                        otherButtonTitles:nil];
    [alert show];
    [alert release];
}

-(void)viewTapped:(UITapGestureRecognizer*)_tapGr
{
    NSLog(@"viewTapped");
    [self.usernameField resignFirstResponder];
    [self.passwordField resignFirstResponder];
    [self.rePasswordField resignFirstResponder];
    [self.emailField resignFirstResponder];
    //[self.usernameField resignFirstResponder];
    //[self.passwordField resignFirstResponder];
}

- (void) initScrolView
{

    CGFloat subheight = self.tabBarController.tabBar.frame.size.height + self.navigationController.navigationBar.frame.size.height + [[UIApplication sharedApplication] statusBarFrame].size.height;
    self.scrolView = [[UIScrollView alloc] initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, self.view.frame.size.height-subheight)];
    //[self.view addSubview: self.scrolView];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
