//
//  CourseLogsViewController.m
//  teaching
//
//  Created by merlin on 14-1-16.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "CourseLogsViewController.h"
#import "LoginViewController.h"
#import "CourseLogListViewController.h"

@interface CourseLogsViewController ()

@end

@implementation CourseLogsViewController

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
    [self initWebView];
    [self showCourseLogsView];
}

- (void)viewWillAppear:(BOOL)animated
{
    if(self.isShowedLoginView)
    {
        self.isShowedLoginView = NO;
        [self showCourseLogsView];
    }
}

-(void) showCourseLogsView
{
    NSBundle *bundle = [NSBundle bundleForClass:[self class]];
    [self loadUser];

	if([self isGuest])
    {
        //[self setNavTitle:@"登录-培训记录"];
        //LoginViewController *loginview = [[LoginViewController alloc]init];
        //[self.view addSubview: loginview.view];
        [self showLoginView];
    }
    else
    {
        NSString *viewTitle = [bundle objectForInfoDictionaryKey:@"APP_TITLE_MY_COURSES"];
        [self setNavTitle:viewTitle];



        //需要地址
        //NSString * logUrl = [NSString stringWithFormat:@"http://coursement.test.icesmart.cn/index.php/地址路径?sid=%@",[self.member valueForKey:@"sid"]];

        NSString * logUrl = URLMAKER(URL_COURSELOGS, [self getUserSid]);

        //[self initWebView];
        //self.webView.frame = CGRectMake(0, 42, self.webView.frame.size.width, self.webView.frame.size.height - 42);
        NSURLRequest *request =[NSURLRequest requestWithURL:[NSURL URLWithString:logUrl]];
        [self.webView loadRequest:request];
    }

    [self addMenuButton];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    [super webView:webView shouldStartLoadWithRequest:request navigationType:navigationType];

    NSLog(@"courselogsviewcontroller request %@",[request URL]);

    if (navigationType == UIWebViewNavigationTypeLinkClicked)
    {

        NSURL *URL = [request URL];


        NSLog(@"courselogsviewcontroller NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);

        NSLog(@"courselogsviewcontroller request url :%@",[URL scheme]);

        if ([[URL scheme] isEqualToString:@"http"])
        {
            NSLog(@"course logs vc is a url A");
            if( TARGET_VERSION_LITE == 1)
            {
                CourseLogListViewController *ctl = [[CourseLogListViewController alloc]initWithUrl:[request URL]];
                [self.navigationController pushViewController:ctl animated:YES];
                [ctl release];
            }
            else if (TARGET_VERSION_LITE == 0 || TARGET_VERSION_LITE == 2)
            {
                //从零学起 与 从零学口语平台进入课程信息
                CourseInfoViewController *courseInfo = [[CourseInfoViewController alloc] initWithUrl:[request URL]];
                [self.navigationController pushViewController:courseInfo animated:YES];
                [courseInfo release];
            }
            NSLog(@"course logs vc is a url B");
        }else{

            //Not a URL
            NSLog(@"course logs vc not a url");
            //return YES;
        }

        return NO;

    }

    return YES;
}

- (void)showLoginView
{

    [super showLoginView];
    LoginViewController *loginview = [[LoginViewController alloc]init];

    [self.navigationController pushViewController:loginview animated:YES];
    [loginview release];
}

- (void)didLoginSuccess
{
    //[self showCourseLogsView];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
