//
//  BaseViewController.m
//  teaching
//
//  Created by merlin on 13-12-18.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "BaseViewController.h"
#import "AppDelegate.h"
#import "UIDevice+IdentifierAddition.h"
#import "SIAlertView.h"

@interface BaseViewController ()

@end

@implementation BaseViewController

@synthesize  member,webView,scrolView, isShowedLoginView;

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
}

-(void) setNavTitle:(NSString *)title
{
    UILabel *titleview = [[UILabel alloc]initWithFrame:CGRectMake(self.navigationItem.titleView.frame.origin.x, 0,self.navigationItem.titleView.frame.size.width,self.navigationItem.titleView.frame.size.height)];
    //UILabel *titleview = [[UILabel alloc]initWithFrame:CGRectMake(0, 0,self.navigationItem.titleView.frame.size.width,self.navigationItem.titleView.frame.size.height)];
    titleview.textColor = [UIColor whiteColor];
    titleview.font = [UIFont systemFontOfSize:18];
    titleview.textAlignment =NSTextAlignmentCenter;
    //titleview.text = title;
    titleview.backgroundColor = [UIColor clearColor];
    
    self.navigationItem.titleView = titleview;
    titleview.text = title;
    [titleview sizeToFit];

    [titleview release];

}

- (void) setNavTitleView:(UIView *)navTitleView
{
    self.navigationItem.titleView = navTitleView;
    [navTitleView release];
}

- (void)showMenu:(id)sender
{
    AppDelegate *app = [[UIApplication sharedApplication] delegate];
    
    DDMenuController *menuController = app.menuController;
    
    [menuController showLeft:sender];
    
    //NSLog(@"show menu");

}

- (NSURL *) changeSidURLByURLString: (NSURL *) inputNSURL changeSid:(NSString *) sid;
{
    //inputString = [NSString stringWithFormat:@"%@%@", inputString, @"&aad=1234567890"];
    NSString *inputString = [inputNSURL absoluteString];
    NSString *outputStr = @"";
    NSRange startRange = [inputString rangeOfString:@"sid="];
    if(startRange.location == NSNotFound)
    {
        return inputNSURL;
    }
    NSString *searchEndStr = [inputString substringFromIndex:startRange.location];
    NSRange endRange = [searchEndStr rangeOfString:@"&"];
    NSString *outputStr1 = [inputString substringToIndex:startRange.location + 4];
    if(endRange.location == NSNotFound)
    {
        outputStr = [NSString stringWithFormat:@"%@%@", outputStr1, sid];
        //NSLog(@"没找到, %@", outputStr);
    }
    else
    {
        NSString *outputStr2 = [searchEndStr substringFromIndex:endRange.location];
        outputStr = [NSString stringWithFormat:@"%@%@%@", outputStr1, sid, outputStr2];
        //NSLog(@"找到了: %@", outputStr);
    }

    return [NSURL URLWithString:outputStr];
}

- (void)addMenuButton
{
    

    UIImage *btnimg = [UIImage imageNamed:@"menubtn"];
    UIButton *btnBack = [UIButton buttonWithType:UIButtonTypeCustom];
    btnBack.frame = CGRectMake(0, 0,22,20);
    
    [btnBack setBackgroundImage:btnimg forState:UIControlStateNormal];
    
    //[btnBack setBackgroundImage:[UIImage imageNamed:@"back.png"] forState:UIControlStateNormal];
    //[btnBack setTitleColor:[UIColor whiteColor] forState:UIControlStateNormal];
    [btnBack setTitle:@"" forState:UIControlStateNormal];
    //btnBack.titleLabel.font = [UIFont boldSystemFontOfSize:13];
    [btnBack addTarget:self action:@selector(showMenu:) forControlEvents:UIControlEventTouchUpInside];
    
    
    UIBarButtonItem *backBtnItem = [[UIBarButtonItem alloc]initWithCustomView:btnBack];
    self.navigationItem.leftBarButtonItem = backBtnItem;
}

- (void)addBackButton
{
    if([self.navigationController.viewControllers count] == 1)
    {
        return ;
    }
    UIImage *btnimg = [UIImage imageNamed:@"backbtn"];
    UIButton *btnBack = [UIButton buttonWithType:UIButtonTypeCustom];
    btnBack.frame = CGRectMake(0, 0,45,20);
    
    [btnBack setBackgroundImage:btnimg forState:UIControlStateNormal];
    
    //[btnBack setBackgroundImage:[UIImage imageNamed:@"back.png"] forState:UIControlStateNormal];
    //[btnBack setTitleColor:[UIColor whiteColor] forState:UIControlStateNormal];
    [btnBack setTitle:@"" forState:UIControlStateNormal];
    //btnBack.titleLabel.font = [UIFont boldSystemFontOfSize:13];
    [btnBack addTarget:self action:@selector(goBack:) forControlEvents:UIControlEventTouchUpInside];
    
    
    UIBarButtonItem *backBtnItem = [[UIBarButtonItem alloc]initWithCustomView:btnBack];
    self.navigationItem.leftBarButtonItem = backBtnItem;
}

- (void)goBack: (id)sender
{
    NSLog(@"self.webView: %@", self.webView);
    if(self.webView)
    {
        [self.webView stopLoading];
    }
    [self.navigationController popViewControllerAnimated:YES];
    
}

- (void)showSearch
{
    
}

- (void)addSearchButton
{
    
    
    UIImage *btnimg = [UIImage imageNamed:@"searchbtn"];
    UIButton *btnBack = [UIButton buttonWithType:UIButtonTypeCustom];
    btnBack.frame = CGRectMake(0, 0,22,24);
    
    [btnBack setBackgroundImage:btnimg forState:UIControlStateNormal];
    [btnBack setTitle:@"" forState:UIControlStateNormal];
    [btnBack addTarget:self action:@selector(showSearch) forControlEvents:UIControlEventTouchUpInside];
    
    
    UIBarButtonItem *backBtnItem = [[UIBarButtonItem alloc]initWithCustomView:btnBack];
    self.navigationItem.rightBarButtonItem = backBtnItem;

    
}

- (NSString *) runWebfunctionByName:(NSString *) functionName
{
    if(webView)
    {
        NSString *function = [NSString stringWithFormat:@"%@();", functionName];
        NSString *webValue = [webView stringByEvaluatingJavaScriptFromString:function];
        return webValue;
    }
    return @"";
}

- (NSString *) runWebfunctionByName:(NSString *) functionName inputStr:(NSString *) str
{
    if(webView)
    {
        NSString *function = [NSString stringWithFormat:@"%@('%@');", functionName, str];
        NSLog(@"function %@", function);
        NSString *webValue = [webView stringByEvaluatingJavaScriptFromString:function];
        return webValue;
    }
    return @"";
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void) initWebView
{
    CGFloat subheight = self.tabBarController.tabBar.frame.size.height + self.navigationController.navigationBar.frame.size.height + [[UIApplication sharedApplication] statusBarFrame].size.height;
    
    NSLog(@"viewHeight:%f, subheight:%f , tabBarHeight:%f , navBarHeight:%f, statusBarHeight:%f",self.view.frame.size.height,subheight,self.tabBarController.tabBar.frame.size.height,self.navigationController.navigationBar.frame.size.height,[[UIApplication sharedApplication] statusBarFrame].size.height);
    
    self.webView = [[UIWebView alloc] initWithFrame:CGRectMake(0,0, self.view.frame.size.width, self.view.frame.size.height-subheight)];
    //self.webView = [[UIWebView alloc] initWithFrame:CGRectMake(0,0, self.view.frame.size.width, self.view.frame.size.height)];
    self.webView.scrollView.bounces = NO;
    [self.webView setDelegate:self];
    [self.view addSubview: self.webView];
    waitView = [[WaitView alloc] initWithParentView:self.view ];
}

- (void) initScrolView
{
    
    CGFloat subheight = self.tabBarController.tabBar.frame.size.height + self.navigationController.navigationBar.frame.size.height + [[UIApplication sharedApplication] statusBarFrame].size.height;
    self.scrolView = [[UIScrollView alloc] initWithFrame:CGRectMake(0, 0, self.view.frame.size.width, self.view.frame.size.height-subheight)];
    
    
    
    //[self.view addSubview: self.scrolView];
    
}
-(void) webViewDidStartLoad:(UIWebView *)webView
{
    NSLog(@"webViewDidStartLoad");
    [waitView show];
}

-(void) webViewDidFinishLoad:(UIWebView *)webView
{
    NSLog(@"base view webViewDidFinishLoad");
    [waitView hide];
}

-(void) webView:(UIWebView *)webView didFailLoadWithError:(NSError *)error
{
    NSLog(@"base didFailLoadWithError:%@", error);
}

-(NSString *)getUDID
{
    return  [[UIDevice currentDevice] uniqueGlobalDeviceIdentifier];
}
-(void) showAlertByTitle:(NSString *)title withMessage:(NSString *)message
{
    
    /*
     UIAlertView *alert = [[UIAlertView alloc] initWithTitle:title message:message delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
     
     [alert show];
     */
    SIAlertView *alertView = [[SIAlertView alloc] initWithTitle:title andMessage:message];
    [alertView addButtonWithTitle:@"OK"
                             type:SIAlertViewButtonTypeDefault
                          handler:^(SIAlertView *alertView) {
                              NSLog(@"OK Clicked");
                              
                          }];
    alertView.titleColor =  [UIColor colorWithRed:206.0/255.0 green:107.0/255.0 blue:102.0/255.0 alpha:1.0]; //[UIColor blueColor];
    alertView.cornerRadius = 10;
    alertView.buttonFont = [UIFont boldSystemFontOfSize:15];
    alertView.transitionStyle = SIAlertViewTransitionStyleBounce;
    
    /*
     alertView.willShowHandler = ^(SIAlertView *alertView) {
     NSLog(@"%@, willShowHandler2", alertView);
     };
     
     
     alertView.didShowHandler = ^(SIAlertView *alertView) {
     NSLog(@"%@, didShowHandler2", alertView);
     };
     alertView.willDismissHandler = ^(SIAlertView *alertView) {
     NSLog(@"%@, willDismissHandler2", alertView);
     };
     alertView.didDismissHandler = ^(SIAlertView *alertView) {
     NSLog(@"%@, didDismissHandler2", alertView);
     };*/
    
    
    [alertView show];
}
- (void) requestFailed:(ASIHTTPRequest *)request
{
    [waitView hide];
    [self showAlertByTitle:NSLocalizedString(@"Failed",nil) withMessage:NSLocalizedString(@"RequestTimeout", nil) ];
}
- (void)dealloc
{
    [self.webView release];
    [super dealloc];
}

- (NSString *) getUserSid
{
    //NSLog(@"getusersid");
    NSString *sid = [self.member valueForKey:@"sid"];
    if(sid == nil)
    {
        sid = @"";
    }
    //NSLog(@"getusersid end");
    return sid;
}

- (BOOL) isGuest
{
    //NSLog(@"isGuest %@",self.member);
    //NSLog(@"isGuest %i",[[self.member valueForKey:@"userid"]intValue]);
    
    //if([[self.member valueForKey:@"uid"]intValue] == 0)
    if([[self.member valueForKey:@"userid"]intValue] == 0)
    {
        return YES;
    }
    else
    {
        return NO;
    }
}

- (NSString *) dateFilePath
{
    NSString *result = nil;
    NSArray *folders = NSSearchPathForDirectoriesInDomains(NSDocumentDirectory, NSUserDomainMask, YES);
    NSString *documentsFolder = [folders objectAtIndex:0];
    result = [documentsFolder stringByAppendingPathComponent:@"data"];
    return result;

    
}
- (void) saveUser
{
    
    NSMutableData *memberdata = [[NSMutableData alloc] init];
    NSKeyedArchiver *archiver = [[NSKeyedArchiver alloc]
                                 initForWritingWithMutableData:memberdata];
    [archiver encodeObject:self.member forKey:@"member"];
    [archiver finishEncoding];
    [memberdata writeToFile:[self dateFilePath] atomically:YES];
    [memberdata release];
    [archiver release];
}

- (void) loadUser
{
    NSLog(@"loadUser");
    if ([[NSFileManager defaultManager] fileExistsAtPath:[self dateFilePath]])
    {
        //NSArray *array = [[NSArray alloc] initWithContentsOfFile:[self dateFilePath]];
        //NSLog(@"loadUser 1");
        NSData *data = [[NSMutableData alloc] initWithContentsOfFile:[self dateFilePath]];
        //NSLog(@"loadUser 2");
        NSKeyedUnarchiver *unarchiver = [[NSKeyedUnarchiver alloc] initForReadingWithData:data];
        //NSLog(@"loadUser 3");
        NSDictionary *memfromfile = [unarchiver decodeObjectForKey:@"member"];
        //NSLog(@"loadUser 4");
        self.member = memfromfile;
        //NSLog(@"loadUser 5");
        [unarchiver finishDecoding];
        //NSLog(@"loadUser 6");
        [memfromfile release];
        //NSLog(@"loadUser 7");
    }
    else
    {
        self.member = [[NSDictionary alloc] initWithObjectsAndKeys:@"0",@"mid", nil];
    }
}

- (void)deleteUser
{
    self.member = [[NSDictionary alloc] initWithObjectsAndKeys:@"0",@"mid", nil];
    [self saveUser];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{


    NSLog(@"base view request %@",[request URL]);
    NSLog(@"base view request request type: %d , UIWebViewNavigationTypeLinkClicked: %d", navigationType, UIWebViewNavigationTypeLinkClicked);
    if (navigationType == UIWebViewNavigationTypeOther || navigationType == UIWebViewNavigationTypeLinkClicked || navigationType == UIWebViewNavigationTypeFormSubmitted)
    {

        NSURL *URL = [request URL];


        NSLog(@"base NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);

        NSLog(@"base view request request url :%@",[URL standardizedURL]);
        NSString *reqURL = [NSString stringWithFormat:@"%@", [URL standardizedURL]];

        NSString *needLoginStr = [NSString stringWithFormat:@"%@%@", API_URL_PREFIX, URL_NEEDLOGIN];
        NSString *gobackStr = [NSString stringWithFormat:@"%@%@", API_URL_PREFIX, URL_GOBACK];
        NSLog(@"-=-=-=- %@", gobackStr);
        if ([reqURL isEqualToString:needLoginStr])
        {
            //NSLog(@"base view goto needlogin");
            [self showLoginView];
        }
        else if([reqURL isEqualToString:gobackStr])
        {
            //Not a URL
            NSLog(@"go back");
            [self goBack:self];
        }
        else
        {
            return YES;
        }
        
        return NO;
        
    }
    
    return YES;
}

- (BOOL)checkString:(NSString *)checkStr isHaveString:(NSString *)tempStr
{
    NSRange rang = [checkStr rangeOfString:tempStr];
    if(rang.length == 0)
    {
        return false;
    }
    return true;
}


-(void) showLoginView
{
    NSLog(@"base view showloginview");
    //如果弹出过logingView 那么所有经过的页面，再次显示时都要进行刷新工作
    self.isShowedLoginView = YES;
    NSArray *controllerArray = self.navigationController.viewControllers;
    NSLog(@"controller list length: %d", [controllerArray count]);
    for (BaseViewController *controller in controllerArray)
    {
        controller.isShowedLoginView = YES;
    }
    [self deleteUser];
    //NewNavTableViewController *tableView = [controllerArray objectAtIndex:0];
    //[tableView getDataList];
    //[tableView.myTableView reloadData];
}

@end
