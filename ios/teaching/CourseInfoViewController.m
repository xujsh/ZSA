//
//  CourseInfoViewController.m
//  teaching
//
//  Created by merlin on 13-12-19.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "CourseInfoViewController.h"
#import "PlayVideoViewController.h"
@interface CourseInfoViewController ()

@end

@implementation CourseInfoViewController

@synthesize courseUrl;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}
- (id) initWithUrl:(NSURL *)url
{
    if( (self=[self init]))
    {
        self.courseUrl = url;
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	NSLog(@"courseinfo vc :view did load");
    //[self setNavTitle:@"课程信息"];
    [self initWebView];
    [self addBackButton];
    [self showViewController];
}


- (void)viewWillAppear:(BOOL)animated
{
    if(self.isShowedLoginView)
    {
        self.isShowedLoginView = NO;
        [self showViewController];
    }
}

- (void) showViewController
{
    [self setNavTitle:@""];
    [self loadUser];
    NSLog(@"url a: %@", self.courseUrl);
    NSLog(@"sid : %@", [self getUserSid]);
    self.courseUrl = [self changeSidURLByURLString:self.courseUrl changeSid:[self getUserSid]];
    NSLog(@"url b: %@", self.courseUrl);
    NSURLRequest *request =[NSURLRequest requestWithURL:self.courseUrl];
    [self.webView loadRequest:request];
}

- (void) webViewDidStartLoad:(UIWebView *)webView
{
    [super webViewDidStartLoad:webView];
}

- (void) webViewDidFinishLoad:(UIWebView *)webView
{
    NSLog(@"--------------------------------------");
    [super webViewDidFinishLoad:webView];
    isBuyed = false;
    NSString *isBuyedStr = [webView stringByEvaluatingJavaScriptFromString:@"isBuyed();"];
    if([isBuyedStr isEqualToString:@"1"])
    {
        isBuyed = true;
    }
    NSLog(@"isBuyed: %d", isBuyed);
    if(!isBuyed)
    {
        NSString *webTitle = [webView stringByEvaluatingJavaScriptFromString:@"returnTitle();"];

        if([webTitle isEqualToString:@""])
        {
            webTitle = @"课程信息";
        }
        [self setNavTitle:webTitle];
    }
    else
    {
        UIButton *infoBtn = [UIButton buttonWithType:UIButtonTypeCustom];
        [infoBtn setBackgroundImage:[UIImage imageNamed:@"infoBtn.png"] forState:UIControlStateNormal];
        [infoBtn setFrame:CGRectMake(-10, -10, 22, 22)];
        [infoBtn addTarget:self action:@selector(didInfoBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        //self.navigationItem.titleView
        self.navigationItem.titleView = infoBtn;
    }
    //[webTitle release];

    //NSLog(@"webtitle: %@", [webView stringByEvaluatingJavaScriptFromString:@"returnTitle();"]);
}

- (void)didInfoBtnClicked:(id)sender
{
    NSLog(@"open");
    [self loadUser];
    NSString *courseid = [self runWebfunctionByName:@"getCourseid"];
    NSLog(@"courseid: %@", courseid);
    NSString *reqStr = [NSString stringWithFormat:@"%@%@", URL_LESSON_INFO, courseid];
    NSURL *URL = [NSURL URLWithString:URLMAKERS(reqStr, [self getUserSid])];
    CommonViewController *classInfo = [[CommonViewController alloc] initWithUrl:URL];
    [self.navigationController pushViewController:classInfo animated:YES];
    [classInfo release];
}

-(BOOL) webView:(UIWebView *)webView shouldStartLoadWithRequest:(NSURLRequest *)request navigationType:(UIWebViewNavigationType)navigationType
{
    [super webView:webView shouldStartLoadWithRequest:request navigationType:navigationType];

    NSLog(@"courseinfoviewcontroller request %@",[request URL]);
    NSLog(@"navigationType, %d", navigationType);

    if (navigationType == UIWebViewNavigationTypeLinkClicked)
    {
        
        NSURL *URL = [request URL];
        
        
        //NSLog(@"NSURL %@,%@,%@,%@",[URL baseURL],[URL lastPathComponent],[URL parameterString],[URL standardizedURL]);
        
        //NSLog(@"request url :%@",[URL scheme]);
        
        if ([[URL scheme] isEqualToString:@"http"])
        {
            NSString *reqURL = [NSString stringWithFormat:@"%@", [URL standardizedURL]];
            NSLog(@"reqURL: %@", reqURL);
            if([self checkString:reqURL isHaveString:URL_TYPE_COURSEPAY])
            {
                CommonViewController *commonCtl = [[CommonViewController alloc] initWithUrl:[request URL]];
                [self.navigationController pushViewController:commonCtl animated:YES];
                [commonCtl release];
            }
            else
            {
                PlayVideoViewController *ctl = [[PlayVideoViewController alloc]initWithUrl:[request URL] ];

                [self.navigationController pushViewController:ctl animated:YES];
                [ctl release];
            }

        }else{
            
            //Not a URL
            
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

- (void) didLoginSuccess
{

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
